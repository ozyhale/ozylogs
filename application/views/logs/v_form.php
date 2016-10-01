<form class="form-horizontal" role="form" action="<?php echo $action; ?>" method="post">
  <div class="form-group">
      <div class="col-sm-12">
          <input type="text" name="title" class="form-control" placeholder="Title" value="<?php if(isset($log)) echo htmlspecialchars($log->title); else echo set_value('title'); ?>" />
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-12">
        <textarea class="form-control" name="text" placeholder="Enter logs" rows="10"><?php if(isset($log)) echo htmlspecialchars($log->text); else echo set_value('text'); ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-12">
      <input type="text" name="datetime" class="form-control" value="<?php if(isset($log)) echo date("Y-m-d H:i:s", strtotime($log->datetime)); else if(isset($time)) echo date("Y-m-d H:i:s", $time); else echo date("Y-m-d H:i:s"); ?>" placeholder="YYYY-MM-DD hh:mm:ss (hours should be in 24 hr format)">
    </div>
  </div>
    
    <!-- This will not be displayed on edits-->
    <?php if(!isset($log)): ?>
        <div class="form-group">
            <div class="col-sm-12">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="wholeday" /> Whole Day
                    </label>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
  <div class="form-group">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>
    </div>
  </div>
</form>