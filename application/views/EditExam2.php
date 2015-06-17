<div id="content-wrapper">

		<div class="page-header">
			<h1><span class="text-light-gray"><a href="<?php site_url(); ?>all-exam">Test Manager</a>/ </span><a href="<?php echo site_url(); ?>add-exam" >Edit Test</a></h1>
		</div> <!-- / .page-header -->

		<div class="row">
			<div class="col-sm-12">
                	<div class="panel">
					<div class="panel-heading">
						<span class="panel-title"><a href="<?php echo site_url(); ?>add-test" >Edit Test</a></span>
					</div>
					<div class="panel-body">
		      	<!-- / Javascript -->
                <?php 
               	$errors = validation_errors();
                if(!empty($errors)): ?>
                    <div class="alert alert-danger">
    					<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
    					<strong>Error</strong>  <?php echo validation_errors(); ?>
    				</div>
                <?php endif; 
                if(!empty($message)): ?>
                    <div class="alert alert-success">
    					<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
    					<strong></strong>  <?php echo $message; ?>
    				</div>
                <?php endif;
                $attributes = array('class' => 'form-horizontal', 'id' => 'myForm');
                echo form_open('edit-exam2?tid='.$_GET['tid'],$attributes); ?>
                            <div class="form-group">
                                <label for="tname" class="text-semibold text-md">Test Name</label>
                                <div  style="text-align: left;">
            	                   <input type="text" name="tname" value='<?php echo $data->name; ?>'  class="form-control"/></label>
                               </div>
            				</div>
                            
                            <div class="form-group">
                            <label for="tquestions" class="text-semibold text-md" >Choose Question</label>
                            
                            <div class="choose_wrapper">
                            <table class="table">
							<thead>
								<tr>
                                    <th>#</th>
									<th>Question</th>
								</tr>
							</thead>
							<tbody>
                            <?php
                            if(is_array($allquestions)){
                                 foreach($allquestions as $key=>$val)
                                        { 
                                            $options = json_decode($data->question_data);
                                            if (in_array($val->id,$options)) {
                                                $class = "active_tupple";
                                                $chk = "checked";
                                            }
                                            else
                                            {
                                                $class = "";
                                                $chk = "";
                                            }
                                            ?>
                                            <tr class="<?php echo $class; ?>">
                                                <td><label class="px-single">
                                                    <input type="checkbox" class="sel_que" name="tquestions[]" value="<?php echo $val->id; ?>" <?php echo $chk; ?> />
                                                    <span class="lbl"></span>
                                                    </label>
                                                </td>
        										<td><?php echo $val->question; ?></td>
        									</tr>
                                            <?php
                                        }
                                }
                            ?>
							</tbody>
						   </table>
                        </div>
                        </div>
                        
                            
                       	<div class="form-group">
								<div class="">
                                <input type="hidden" name="test_type" value="2"/>
                                    <input type="hidden" name="test_id" value="<?php echo $_GET['tid']; ?>"/>
									<input type="submit" class="btn btn-primary" value="Update Test" />
								</div>
							</div>
						</form>
					</div>
				</div>
<!-- /5. $JQUERY_VALIDATION -->

<!-- /10. $FORM_EXAMPLE -->

			</div>
		</div>
        
                           
 </div>
      