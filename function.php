<?php

require 'include/dbConnection.php';

function error422($message)
{
  $data = [
    'status'  => 422,
    'message' => $message,
  ];

  header('HTTP/1.0 422 Unprocessable Entity');
  echo json_encode($data);
  exit();
}

function getPlayerList()
{
  global $conn;

  $query    = 'SELECT * FROM player';
  $queryRun = mysqli_query($conn, $query);

  if ($queryRun) {

    if (mysqli_num_rows($queryRun) > 0) {

      $res = mysqli_fetch_all($queryRun, MYSQLI_ASSOC);

      $data = [
        'status'  => 200,
        'message' => 'Success player list fetched',
        'data'    => $res
      ];

      header('HTTP/1.0 200 Success');
      return json_encode($data);
    } else {
      $data = [
        'status'  => 404,
        'message' => 'Player not found'
      ];

      header('HTTP/1.0 404 Player Not Found');
      return json_encode($data);
    }
  } else {
    $data = [
      'status'  => 500,
      'message' => 'Internal server error'
    ];

    header('HTTP/1.0 505 Internal Server Error!');
    return json_encode($data);
  }
}

function getPlayerbyId($playerParams)
{

  global $conn;

  if ($playerParams['id'] == null) {
    return error422('Enter your player id');
  }

  $playerId = mysqli_real_escape_string($conn, $playerParams['id']);

  $query  = "SELECT * FROM player WHERE id='$playerId' LIMIT 1";
  $result = mysqli_query($conn, $query);

  if ($result) {
    if (mysqli_num_rows($result) == 1) {
      $res = mysqli_fetch_assoc($result);

      $data = [
        'status'  => 200,
        'message' => 'Success player list fetched',
        'data'    => $res
      ];

      header('HTTP/1.0 200 OK');
      return json_encode($data);
    } else {
      $data = [
        'status'  => 404,
        'message' => 'Player not found'
      ];

      header('HTTP/1.0 404 Not Found');
      return json_encode($data);
    }
  } else {
    $data = [
      'status'  => 500,
      'message' => 'Internal server error'
    ];

    header('HTTP/1.0 505 Internal Server Error!');
    return json_encode($data);
  }
}

function storePlayer($playerInput)
{
  global $conn;

  $name = mysqli_real_escape_string($conn, $playerInput['name']);
  $date_of_birth = mysqli_real_escape_string($conn, $playerInput['date_of_birth']);
  $place_of_birth = mysqli_real_escape_string($conn, $playerInput['place_of_birth']);
  $citizenship = mysqli_real_escape_string($conn, $playerInput['citizenship']);
  $position = mysqli_real_escape_string($conn, $playerInput['position']);
  $foot = mysqli_real_escape_string($conn, $playerInput['foot']);
  $current_club = mysqli_real_escape_string($conn, $playerInput['current_club']);

  if (empty(trim($name))) {
    return error422('Enter your name');
  } elseif (empty(trim($date_of_birth))) {
    return error422('Enter your birthday');
  } elseif (empty(trim($place_of_birth))) {
    return error422('Enter your place birth');
  } elseif (empty(trim($citizenship))) {
    return error422('Enter your city');
  } elseif (empty(trim($position))) {
    return error422('Enter your position');
  } elseif (empty(trim($foot))) {
    return error422('Enter your foot');
  } elseif (empty(trim($current_club))) {
    return error422('Enter your club');
  } else {
    $query    = "INSERT INTO player (name, date_of_birth, place_of_birth, citizenship, position, foot, current_club) VALUES ('$name', '$date_of_birth', '$place_of_birth', '$citizenship', '$position', '$foot', '$current_club')";
    $queryRun = mysqli_query($conn, $query);

    if ($queryRun) {

      $data = [
        'status'  => 201,
        'message' => 'Player created'
      ];

      header('HTTP/1.0 201 Created');
      return json_encode($data);
    } else {
      $data = [
        'status'  => 500,
        'message' => 'Internal server error'
      ];

      header('HTTP/1.0 505 Internal Server Error!');
      return json_encode($data);
    }
  }
}

function updatePlayer($playerInput, $playerParams)
{
  global $conn;

  if (!isset($playerParams['id'])) {
    return error422('Player id not found');
  } elseif ($playerParams['id'] == null) {
    return error422('Enter the player id');
  }

  $playerId = mysqli_real_escape_string($conn, $playerParams['id']);

  $name = mysqli_real_escape_string($conn, $playerInput['name']);
  $date_of_birth = mysqli_real_escape_string($conn, $playerInput['date_of_birth']);
  $place_of_birth = mysqli_real_escape_string($conn, $playerInput['place_of_birth']);
  $citizenship = mysqli_real_escape_string($conn, $playerInput['citizenship']);
  $position = mysqli_real_escape_string($conn, $playerInput['position']);
  $foot = mysqli_real_escape_string($conn, $playerInput['foot']);
  $current_club = mysqli_real_escape_string($conn, $playerInput['current_club']);

  if (empty(trim($name))) {
    return error422('Enter your name');
  } elseif (empty(trim($date_of_birth))) {
    return error422('Enter your birthday');
  } elseif (empty(trim($place_of_birth))) {
    return error422('Enter your place birth');
  } elseif (empty(trim($citizenship))) {
    return error422('Enter your city');
  } elseif (empty(trim($position))) {
    return error422('Enter your position');
  } elseif (empty(trim($foot))) {
    return error422('Enter your foot');
  } elseif (empty(trim($current_club))) {
    return error422('Enter your club');
  } else {
    $query    = "UPDATE player SET name='$name', date_of_birth='$date_of_birth', place_of_birth='$place_of_birth', citizenship='$citizenship', position='$position', foot='$foot', current_club='$current_club' WHERE id='$playerId' LIMIT 1";
    $result   = mysqli_query($conn, $query);

    if ($result) {

      $data = [
        'status'  => 200,
        'message' => 'Player updated'
      ];

      header('HTTP/1.0 200 Success');
      return json_encode($data);
    } else {
      $data = [
        'status'  => 500,
        'message' => 'Internal server error'
      ];

      header('HTTP/1.0 505 Internal Server Error!');
      return json_encode($data);
    }
  }
}

function deletePlayer($playerParams)
{
  global $conn;

  if (!isset($playerParams['id'])) {
    return error422('Player id not found');
  } elseif ($playerParams['id'] == null) {
    return error422('Enter the player id');
  }

  $playerId = mysqli_real_escape_string($conn, $playerParams['id']);

  $query  = "DELETE FROM player WHERE id='$playerId' LIMIT 1";
  $result = mysqli_query($conn, $query);

  if ($result) {

    $data = [
      'status'  => 200,
      'message' => 'Success Deleted Player'
    ];

    header('HTTP/1.0 200 OK');
    return json_encode($data);
  } else {
    $data = [
      'status'  => 404,
      'message' => 'Player not found in url'
    ];

    header('HTTP/1.0 404 Not Found');
    return json_encode($data);
  }
}
