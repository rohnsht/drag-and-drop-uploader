<!DOCTYPE html>
<html>
<head>
	<title>Drag and Drop image uploader</title>
	<link rel="stylesheet" href="bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Image Uploader</a>
			</div>
		</div>
	</div>

	<div class="container">
			<div id="main" class="col-md-6 col-md-offset-3">
				<div class="col-md-12">
					<h3>Upload image here</h3>
					<div id="image-uploader">
						<span>Drag your image here to upload.</span>
					</div>
				</div>

				<div class="col-md-12">
					<div class="progress">
					  	<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
					    	<span class="sr-only">0% Complete (success)</span>
					  	</div>
					</div>
				</div>
			
				<div id="image" class="col-md-12">

				</div>
			</div>
	</div>

	<script src="jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			$(".progress").hide();

			$("#image-uploader").on('dragover',function(e){
				e.stopPropagation();
				e.preventDefault();
				$(this).css('border','2px solid #1abc9c');
			});

			$("#image-uploader").on('drop',function(e){
				e.stopPropagation();
				e.preventDefault();
				$(this).css('border','1px dotted #555');

				var files = e.originalEvent.dataTransfer.files;
				var file = files[0];
				console.log(file);				
				upload(file);
			});
		});

		function upload(file){
			var name = file.name;
			var ext = name.substr(name.lastIndexOf(".")+1).toLowerCase();
	
			if(ext == 'jpg' || ext == 'jpeg' || ext == 'gif' || ext == 'png'){
				var formdata = new FormData();
				formdata.append('file',file);
				console.log(formdata);

				$.ajax({
					method: 'POST',
		            url: 'upload.php',
		            xhr: function(){
		                var xhr = new window.XMLHttpRequest();
		                xhr.upload.addEventListener("progress", function(evt){
		                    if(evt.lengthComputable) {
		                        var percentComplete = (evt.loaded / evt.total)*100;
	                            $(".progress").show();
	                            $(".progress-bar").css("width", percentComplete + "%");
	                            $(".progress-bar").text(parseInt(percentComplete) + "%");    
		                    }
		                }, false);       
		                return xhr;
		            },
		            contentType:false,
	        		processData: false,
	        		dataType: 'json',
		            data: formdata,
		            success: function(data){
		            	console.log(data.path);
		            	$("#image").html('<img class="img-responsive" src="'+data.path+'">');
		            }

				});
			}
			else{
				alert("You can only upload image file");
			}
		}
	</script>
</body>
</html>