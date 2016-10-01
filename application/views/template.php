<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title>Ozy's Logging System</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap-sandstone.min.css'); ?>">

    <script src="<?php echo base_url('assets/jquery/jquery.min.js'); ?>"></script>
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
    
    <style type="text/css">
      body{
        margin-top: 25px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          
          <h1>Ozy's Logs</h1>
          
          <p>
            <a href="<?php echo site_url('home'); ?>">Create Log</a> | 
            <a href="<?php echo site_url('logs/index/latest'); ?>">Logs</a> | 
            <a href="<?php echo site_url('calendar'); ?>">Calendar</a>
          </p>
          
          <?php if(isset($NOTIFICATION_ERROR)): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
              </button>
              <strong>Error!</strong> <?php echo $NOTIFICATION_ERROR; ?>
            </div>
          <?php endif; ?>
          
          <?php if(isset($NOTIFICATION_WARNING)): ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
              </button>
              <strong>Warning!</strong> <?php echo $NOTIFICATION_WARNING; ?>
            </div>
          <?php endif; ?>
          
          <?php if(isset($NOTIFICATION_INFO)): ?>
            <div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
              </button>
              <strong>Heads Up!</strong> <?php echo $NOTIFICATION_INFO; ?>
            </div>
          <?php endif; ?>
          
          <?php if(isset($NOTIFICATION_SUCCESS)): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
              </button>
              <strong>Alright!</strong> <?php echo $NOTIFICATION_SUCCESS; ?>
            </div>
          <?php endif; ?>
          
          <?php echo $CONTENT; ?>
          
        </div>
      </div>
    </div>
  </body>
</html>
