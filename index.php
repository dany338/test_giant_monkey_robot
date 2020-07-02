<?php
  include_once './conexion.php';
  $objeto   = new Conexion();
  $conexion = $objeto->Conectar();

  $search = "SELECT * FROM queues";
  $result = $conexion->prepare($search);
  $result->execute();
  $queues = $result->fetchAll(PDO::FETCH_ASSOC);

  echo "Example Initial for queue!!";

  $pq = new SplPriorityQueue();

  // The insert method inserts an element in the queue by shifting it up
  $pq->insert('A', 3);
  $pq->insert('B', 6);
  $pq->insert('C', 1);
  $pq->insert('D', 2);

  // Count the elements
  echo "count ->" . $pq->count() . PHP_EOL;

  // Sets the mode of extraction (EXTR_DATA, EXTR_PRIORITY, EXTR_BOTH)
  $pq->setExtractFlags(SplPriorityQueue::EXTR_BOTH);

  // Go at the node from the top of the queue
  $pq->top();

  // Iterate the queue (by priority) and display each element
  echo "<pre>";
  while ($pq->valid()) {
      print_r($pq->current());
      echo PHP_EOL;
      $pq->next();
  }
  echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>web-api server</title>
</head>
<body>
  <div class="row">
    <div class="col s12">
      <pre id="tableQueuesPre">
      </pre>
    </div>
  </div>
  <div id="loader" class="row" style="display: none;">
    <div class="progress">
        <div class="indeterminate"></div>
    </div>
  </div>
  <div class="row">
    <div class="col s12">
      <table id="tableQueues" class="table-striped table-bordered" style="width:100%">
          <thead class="text-center">
              <th>#</th>
              <th>Job id</th>
              <th>Submitter’s id</th>
              <th>Processor’s id</th>
              <th>Command to execute</th>
          </thead>
          <tbody>
              <?php
                  foreach($queues as $queue){
              ?>
              <tr>
                  <td><?php echo $queue['id']?></td>
                  <td><?php echo $queue['job_id']?></td>
                  <td><?php echo $queue['submitters_id']?></td>
                  <td><?php echo $queue['processors_id']?></td>
                  <td><?php echo $queue['command_to_execute']?></td>
              </tr>
              <?php
                  }
              ?>
          </tbody>
      </table>
    </div>
  </div>
  <div class="row">
      <div class="row">
        <div class="input-field col s6 m3">
          <button id="btn-add-jobs" class="btn waves-effect waves-light" type="button" name="action">Add more jobs
            <i class="material-icons right">plus_one</i>
          </button>
        </div>
      </div>
      <div id="section-rows-fields-jobs"></div>
      <div class="row">
        <div class="input-field col s6 m3">
          <button id="btn-send-jobs" class="btn waves-effect waves-light" type="button" name="action">Submit
            <i class="material-icons right">send</i>
          </button>
        </div>
      </div>
  </div>

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="./app.js"></script>
</body>
</html>
