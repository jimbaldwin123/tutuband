<?php

print_r($_FILES);


		copy($_FILES['upload_image'][tmp_name],"test/" . $_FILES['upload_image'][name]);
		//unlink($_FILES[$image_name][tmp_name]);

?>