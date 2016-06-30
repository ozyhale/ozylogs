<div class="row">
    <div class="col-sm-2">
        <select id="month_year_filter_selections" class="form-control" onchange="filter();">
            <option value="" <?php if("" === $month_year_filter) echo 'selected'; ?>>All</option>
            <?php foreach($month_year_filter_selections as $value2): ?>
            <?php
                $optionValue = strtolower(str_replace(" ", "-", $value2));
            ?>
            <option value="<?php echo $optionValue; ?>" <?php if($optionValue === $month_year_filter) echo 'selected'; ?>>
                <?php echo $value2; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-sm-10">
        <button class="btn btn-primary btn-sm pull-right" onclick="redirect('<?php echo site_url('logs/export/' . $month_year_filter); ?>')">Export</button>
    </div>
</div>

<div class="row" style="margin-top: 14px;">
    <div class="col-sm-12">
        <ul class="list-group">
            <?php foreach ($logs as $value): ?>
                <li href="#" class="list-group-item" 
                    <?php 
                    
                    if(date('N', strtotime($value->datetime)) == "7" || date('N', strtotime($value->datetime)) == "6"){
                        echo 'style="background-color: #F2DEDE; color: #D9534F;"'; 
                    }else if(date('a', strtotime($value->datetime)) == "pm"){
                        echo 'style="background-color: #DFF0D8; color: #3C763D;"'; 
                    }
                    
                    ?>
                    
                    >
                    <small class="pull-right">
                        <?php echo date('l F d, Y h:i:s a', strtotime($value->datetime)); ?>
                    </small>
                    <h4 class="list-group-item-heading">
                        <?php echo $value->title; ?>
                    </h4>
                    <p>
                        <small>
                            <?php if($value->id != 0): ?>
                                <a href="javascript:deleteLog('<?php echo $value->id; ?>')">Delete</a> | 
                            <?php else: ?>
                                <span class="text-muted">Delete</span> | 
                            <?php endif; ?>
                            
                            <?php if($value->id != 0): ?>
                                <a href="<?php echo site_url('logs/edit/' . $value->id); ?>">Edit</a> | 
                            <?php else: ?>
                                <a href="<?php echo site_url('logs/create/' . strtotime($value->datetime)); ?>">Edit</a> | 
                            <?php endif; ?>
                            
                            <?php if($value->id != 0): ?>
                                <a href="<?php echo site_url('logs/duplicate/' . $value->id); ?>">Duplicate</a>
                            <?php else: ?>
                                <span class="text-muted">Duplicate</span>
                            <?php endif; ?>
                        </small>
                    </p>
                    <p>
                        <?php echo $value->text; ?>
                    </p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script type="text/javascript">

    function redirect(url) {
        window.location.href = url;
    }

    function deleteLog(id) {
        var result = confirm('Are you sure you want to delete this log?');

        if (result === true) {
            redirect('<?php echo site_url('logs/delete'); ?>/' + id);
        }
    }
    
    function filter(){
        var month_year = $('#month_year_filter_selections').val();
        redirect('<?php echo site_url('logs/index'); ?>/' + month_year);
    }

</script>