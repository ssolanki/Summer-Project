<!DOCTYPE html>
<html>
<head>
    <title>BootstrapValidator demo</title>

    <link rel='stylesheet' href='css/bootstrap.css'/>
    <link rel='stylesheet' href='css/bootstrapValidator.css'/>
	<link rel='stylesheet' href='css/style.css'/>
    <script type='text/javascript' src='js/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src='js/bootstrap.min.js'></script>
    <script type='text/javascript' src='js/bootstrapValidator.min.js'></script>
	
</head>
<body>
    <div class='container'>
        <div class='row'>
            <!-- form: -->
            <section>
            
					<form id='newpax_Form' class='form-horizontal' method='post' action='target.php'>
					<div class='form-group'>
						<label class='col-sm-2 control-label' >Your Name </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id=''  name='pax_name' placeholder='Your Name'  autocomplete='off'>
						</div>
						
						<label class='col-sm-2 control-label'>Date-of-Birth </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' name='dob' placeholder='Year-month-day'   autocomplete='off'>
						</div>
						<label class='col-sm-2 control-label'>Sex</label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id=''  placeholder='Type M or F' name='sex' autocomplete='off'>
						</div>
						
					</div>
							
					<div class='form-group'>
						<label class='col-sm-2 control-label'>Contact Number</label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' name='contact_no'  placeholder='Use ISD code also' autocomplete='off'>
						</div>
						<label class='col-sm-2 control-label' >Address </label>
						<div class='col-sm-2'>
							<textarea type='text' class='form-control' id=''  name='contact_info' placeholder='Your Address'  autocomplete='off'> </textarea>
						</div>
						
						<label class='col-sm-2 control-label'>Passenger Type </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' placeholder='Type PAX or CRW'  name='pax_type' autocomplete='off'>
						</div>
						
					</div>
					<div class='form-group'>
						<label class='col-sm-2 control-label'>Nationality </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id=''  name='pax_nalty_code' placeholder='Use 3 characters'   autocomplete='off'>
						</div>
						<label class='col-sm-2 control-label'>Passenger Status</label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' name='pax_status'  placeholder='Type T or D' autocomplete='off'>
						</div>
						<label class='col-sm-2 control-label'>Doc Type </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' name='doc_type' placeholder='O or P'    autocomplete='off'>
						</div>
					</div>		
					<div class='form-group'>					
					<label class='col-sm-2 control-label' >Document Number </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id=''   name='doc_no' placeholder='Document Number'   autocomplete='off'>
						</div>
						
						<label class='col-sm-2 control-label'>Expiry Date  </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' placeholder=' Year-month-day' name='doc_expiry_date' autocomplete='off'>
						</div>
						<label class='col-sm-2 control-label'>Doc Issue Country</label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' name='doc_issue_country' placeholder='Use 3 character' autocomplete='off'>
						</div>
					</div>
					<div class='form-group'>
						<label class='col-sm-2 control-label'>Visa Number </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' name='visa_no'  placeholder='Visa Number'    autocomplete='off'>
						</div>
						<label class='col-sm-2 control-label' >Visa Issue Date </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' name='visa_issue_date' placeholder=' Year-month-day'  autocomplete='off'>
						</div>
						
						<label class='col-sm-2 control-label'>Visa Issue Place </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' placeholder='Use 3 characters' name='visa_issue_place' autocomplete='off'>
						</div>
						
					</div>
					<div class='form-group'>
						<label class='col-sm-2 control-label'>Residence Country</label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' name='resi_country' placeholder='Use 3 characters' autocomplete='off'>
						</div>
						<label class='col-sm-2 control-label' >Flight Number </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' name='flight_no' placeholder='Flight number'  autocomplete='off'>
						</div>
						
						<label class='col-sm-2 control-label'>Flight Departure Date </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' placeholder=' Year-month-day' name='flight_dept' autocomplete='off'>
						</div>
					</div>
					<div class='form-group'>
						<label class='col-sm-2 control-label'>Flight Arrival Date</label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' name='flight_arr' placeholder=' Year-month-day' autocomplete='off'>
						</div>
						<label class='col-sm-2 control-label' > LAST_LEG_PORT </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' name='last_leg' placeholder=' Year-month-day'  autocomplete='off'>
						</div>
						
						<label class='col-sm-2 control-label'>FIRST Airport</label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' placeholder='Use 3 characters' name='first_port' autocomplete='off'>
						</div>
					</div>
					<div class='form-group'>
						<label class='col-sm-2 control-label'>Carrier Code</label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' name='carrier_code' placeholder='Use 3 characters' autocomplete='off'>
						</div>
						<label class='col-sm-2 control-label' >Disembark Port </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' name='disembark_port' placeholder='Use 3 characters'  autocomplete='off'>
						</div>
						
						<label class='col-sm-2 control-label'>Embark Country</label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id='' placeholder='Use 3 characters' name='embark_country' autocomplete='off'>
						</div>
					</div>
					<div class='form-group'>
						<label class='col-sm-2 control-label'>Embark Port </label>
						<div class='col-sm-2'>
							<input type='text' class='form-control' id=''  name='embark_port' placeholder='Use 3 characters' autocomplete='off'>
						</div>
						<label class='col-sm-2 control-label' >Suspect type:</label> 
						<div class='col-sm-2 suspectType' >	<label id='susp'> Suspect </label> <input type='radio' name='auth_decision' class='' value='0'> 
							<label id='notsusp'> Not Suspect </label><input type='radio' name='auth_decision' class='' value='1'>
							<label id='maybe'> May be </label>	<input type='radio' name='auth_decision' class='' value='2'>
						</div>
						
						<label class='col-sm-2 control-label'>Authority comment</label>
						<div class='col-sm-2'>
							<textarea name='auth_comment' rows='2' class='form-control' placeholder='Comment about passenger' id='' autocomplete='off'> </textarea>
				
						</div>
					</div>
					<div class='form-group'>
						<div class='col-lg-9 col-lg-offset-6'>
							<button type='submit' class='btn btn-primary' name='submit_info'>Submit</button>
						</div>
					</div>						
				</form>
		  </section>
		  </div>
            
            <!-- :form -->
    </div>

<script type='text/javascript'>
$(document).ready(function() {
    $('#newpax_Form').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                message: 'This field is not valid',
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }                    
                }
            },
			 pax_name: {
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			dob:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			sex:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			contact_no:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			contact_info:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			pax_type:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			pax_nalty_code:{
				 message: 'The Nalty Code is not valid',
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }	
				}
                    
            },
			pax_status:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			doc_no:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			doc_type:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			doc_number:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			doc_expiry_date:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			doc_issue_country:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			visa_no:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			visa_issue_date:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			visa_issue_place:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			resi_country:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			flight_no:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			flight_dept:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			flight_arr:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			last_leg:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			first_port:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			carrier_code:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			disembark_country:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			embark_country:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			embark_port:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			disembark_port:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			auth_comment:{
                validators: {                    
				stringLength: {
						
                        max: 100,
                        message: 'Please comment briefly in 100 characters'
                    }
                }
            }
			
			
        }
    });
});
</script>
</body>
</html>