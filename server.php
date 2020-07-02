<?php
$data = json_decode(file_get_contents('php://input'), true);
include_once './conexion.php';
$objeto   = new Conexion();
$conexion = $objeto->Conectar();

$search = "SELECT * FROM queues";
$result = $conexion->prepare($search);
$result->execute();
$queues = $result->fetchAll(PDO::FETCH_ASSOC);

$pq = new SplPriorityQueue();

// The insert method inserts an element in the queue by shifting it up
// $pq->insert('A', 3);
// $pq->insert('B', 6);
// $pq->insert('C', 1);
// $pq->insert('D', 2);

foreach ($data['jobs'] as $index => $job):
  $pq->insert($job['submitters_id'], $job['job_id']);
endforeach;
// Count the elements
// echo "count ->" . $pq->count() . PHP_EOL;

// // Sets the mode of extraction (EXTR_DATA, EXTR_PRIORITY, EXTR_BOTH)
$pq->setExtractFlags(SplPriorityQueue::EXTR_BOTH);

// // Go at the node from the top of the queue
$pq->top();

// Iterate the queue (by priority) and display each element
$index = 0;
$priorities = [];
while ($pq->valid()) {
    // print_r($pq->current());
    $priorities[] = $pq->current();
    echo PHP_EOL;
    $job_id             = $data['jobs'][$index]['job_id'];
    $submitters_id      = $data['jobs'][$index]['submitters_id'];
    $processors_id      = $data['jobs'][$index]['processors_id'];
    $command_to_execute = $data['jobs'][$index]['command_to_execute'];

    $consulta = "INSERT INTO queues(job_id, submitters_id, processors_id, command_to_execute) VALUES('$job_id', '$submitters_id', '$processors_id', '$command_to_execute') ";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $index++;
    $pq->next();
}

print json_encode($priorities, JSON_UNESCAPED_UNICODE);

?>
