<?php

use Symfony\Component\HttpFoundation\Request;

$app = require_once(__DIR__.'/../src/bootstrap.php');

$app['team_members'] = array(
  '**' => 'everyone',
  'AF' => 'André Esteves',
  'DG' => 'Diogo Gomes',
  'FM' => 'Francisco Mendes',
  'JS' => 'Joaquim Santos',
  'LF' => 'Luís Faceira',
  'MG' => 'Marcos Gomes',
  'RL' => 'Ricardo Lameiro'
);

$app->get('', function() use ($app) { 
    return $app['twig']->render('index.html', array(
        'team_members' => $app['team_members']
    ));
}); 

$app->get('messages/get_one', function() use ($app) {
    $sql = 'SELECT * FROM messages WHERE sent = ? ORDER BY timestamp ASC';
    $message = $app['db']->fetchAssoc($sql, array(0));
    if ($message === false)
    {
        return "EMPTY";
    }
    else
    {
        $sql = "UPDATE messages SET sent = ? WHERE id = ?";
        $app['db']->executeUpdate($sql, array(1, $message['id']));
    }
    
    return $message['deviceID'].$message['text'];
});

$app->post('messages', function(Request $request) use ($app) {
    $now = new \DateTime();

    $deviceID = $request->get('deviceID');
    $newMessageData = array(
        'deviceID' => $deviceID,
        'text' => $request->get('text'),
        'timestamp' => $now->format('Y-m-d H:i:s')
    );

    $app['db']->insert('messages', $newMessageData);
    
    $team_members = $app['team_members'];

    return $app['twig']->render('form.html', array(
        'deviceID' => $deviceID,
        'target' => $team_members[$deviceID],
        'sent' => true
    ));
});

$app->get('{deviceID}', function($deviceID) use ($app) {
    
    $team_members = $app['team_members'];

    return $app['twig']->render('form.html', array(
        'deviceID' => $deviceID,
        'target' => $team_members[$deviceID],
        'sent' => false
    ));
})->assert('deviceID', '^[a-zA-Z*]{2}|all');

$app->run();