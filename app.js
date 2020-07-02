// Identifiers & constants
const $btnAddJobs            = document.getElementById('btn-add-jobs');
const $sectionRowsFieldsJobs = document.getElementById('section-rows-fields-jobs');
const $btnSendJobs           = document.getElementById('btn-send-jobs');
const $tableQueuesPre        = document.getElementById('tableQueuesPre');
const $loader                = document.getElementById('loader');
let count                    = 0;
const URL_WEB_API_SERVER     = './server.php';

const apiHeaders = {
  'Content-Type': 'application/json',
  Accept: 'application/json',
};

const fetchParams = (method, data = '') => {
  const body = data ? { body: JSON.stringify(data) } : {};

  // if(Array.isArray(data)) {
    const newApiHeaders = new Headers();
    // newApiHeaders.append("Content-Type", "application/json");
    newApiHeaders.append("Accept", "application/json");
    return {
      method,
      headers: newApiHeaders,
      credentials: 'same-origin',
      ...body,
    };
  // }

  // return {
  //   method,
  //   headers: apiHeaders,
  //   credentials: 'same-origin',
  //   ...body,
  // };
};

const htmlBaseInitialFieldsJobs = index => {
  const html = /* html */ `
    <div class="row">
      <div class="input-field col s12 m3">
        <i class="material-icons prefix">group_work</i>
        <input placeholder="job id" id="job_id_${index}" name="Jobs[${index}][job_id]" type="text" class="validate" required>
        <label for="job_id_${index}">Job id</label>
      </div>
      <div class="input-field col s12 m3">
        <i class="material-icons prefix">account_box</i>
        <input placeholder="submitter’s id" id="submitters_id_${index}" name="Jobs[${index}][submitters_id]" type="text" class="validate" required>
        <label for="submitters_id_${index}">Submitter’s id</label>
      </div>
      <div class="input-field col s12 m3">
        <i class="material-icons prefix">dns</i>
        <input placeholder="processor’s id" id="processors_id_${index}" name="Jobs[${index}][processors_id]" type="text" class="validate" required>
        <label for="processors_id_${index}">Processor’s id</label>
      </div>
      <div class="input-field col s12 m3">
        <i class="material-icons prefix">copyright</i>
        <input placeholder="command to execute" id="command_to_execute_${index}" name="Jobs[${index}][command_to_execute]" type="text" class="validate" required>
        <label for="command_to_execute_${index}">Command to execute</label>
      </div>
    </div>
    `;

  return html;
};

const processingJobsQueue = async jobs => {
  const newObj = {
    opc: 1, // INSERT ADD JOBS
    jobs,
  }
  const response = await fetch(`${URL_WEB_API_SERVER}`, fetchParams('POST', { ...newObj }));
  const data = await response.json();
  console.log('data', data);
  $tableQueuesPre.innerHTML = JSON.parse(data);
  $loader.style.display = 'none';
};

$btnAddJobs.addEventListener("click", event => {
  event.preventDefault();
  const htmlSections = $sectionRowsFieldsJobs.innerHTML;
  console.log('htmlSections', htmlSections);
  $sectionRowsFieldsJobs.innerHTML = htmlSections + htmlBaseInitialFieldsJobs(count);
  count += 1;
  M.AutoInit();
  M.updateTextFields();
  event.stopPropagation();
});

$btnSendJobs.addEventListener("click", event => {
  event.preventDefault();
  $inputs = document.querySelectorAll('input');
  let isInputsEmpties = 0;
  $inputs.forEach(input => {
    if(input.value === '') {
      isInputsEmpties += 1;
    }
  });

  if(isInputsEmpties === 0) {
    $loader.style.display = 'inline';
    let jobs = [];
    for (let index = 0; index < count; index++) {
      const job_id             = document.getElementById('job_id_' + index).value;
      const submitters_id      = document.getElementById('submitters_id_' + index).value;
      const processors_id      = document.getElementById('processors_id_' + index).value;
      const command_to_execute = document.getElementById('command_to_execute_' + index).value;
      jobs = [ ...jobs, { job_id, submitters_id, processors_id, command_to_execute }];
    }
    processingJobsQueue(jobs);
  } else {
    M.toast({html: 'there are fields to fill!'});
  }
  event.stopPropagation();
});
