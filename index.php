<?php
	error_reporting(0);
	// HASH GENERATOR START
	
	if(!empty($_POST))
	{
		$algo = $_POST['algo'];
		$message = $_POST['message'];	
		if($algo == "md5")
		{
			$encrypt = md5($message);
			$length = strlen($encrypt);
		}
		elseif($algo == "sha1")
			{
					$encrypt = sha1($message);
					$length = strlen($encrypt);	
			}
			elseif($algo == "sha256")
				{
					$encrypt = hash('sha256',$message);
					$length = strlen($encrypt);	
				}
				elseif($algo == "sha512")
					{
						$encrypt = hash('sha512',$message);
						$length = strlen($encrypt);	
					}
					elseif($algo == "crc32")
						{
							$encrypt = hash('crc32',$message);
							$length = strlen($encrypt);
						}
						elseif($algo == "techVegan")
							{
								$encrypt = techVegan($message);
								$length = strlen($encrypt);
							}				
		
	}
		
	function techVegan($msg)
	{
			$encryptedText = hash('sha512',hash('crc32',hash('sha1',hash('md5',hash('sha256',$msg)))));
			return $encryptedText;
	}
		// HASH GENERATOR END
		
		// CRYPTOGRAPHY CODE START
		if(!empty($_POST['CRYPTO']))
		{
			if($_POST['CRYPTO'] == "ENCRYPT")
			{
				$data = secret('enc',$_POST['data']); // Function Call
				$len = strlen($data);	
			}
			elseif($_POST['CRYPTO'] == "DECRYPT")
				{
					$data = secret('dec',$_POST['data']); // Function Call
					$len = strlen($data);	
				}
		}
		
		function secret($type, $data) // Function Definition
		{
			$output = false;
			$encryptionMethod = "AES-256-CBC"; // AES-256-CBC // AES-128-CBC // AES-192-CBC	
			
			$secretKey = 'Area51';
			$secretIv = 'Area51';
			
			$secretKeyHash = hash('sha256',$secretKey);
			$secretIvHash = substr(hash('sha256',$secretIv),0,16);
			
			if($type == 'enc') 
			{
				$output = openssl_encrypt($data, $encryptionMethod, $secretKeyHash,0,$secretIvHash);
				$output = base64_encode($output);
				return $output;
			}
			elseif($type == 'dec')
				{
					$output = base64_decode($data);
					$output = openssl_decrypt($output, $encryptionMethod, $secretKeyHash,0,$secretIvHash);
					return $output;
				}
		}
		// CRYPTOGRAPHY CODE END
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cryptography</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include('navbar.php');?>
<div class="container">
  <h4 class="display-4 border-bottom py-4">HASH GENERATOR</h4>
  <div class="row row-cols-1 row-cols-md-1">
    <form method="post" action="">
      <div class="col mb-3">
        <input type="text" class="form-control" placeholder="Enter any message" name="message" required>
      </div>
      <div class="col mb-3">
        <select class="form-select form-select mb-3" aria-label=".form-select-lg example" name="algo" required>
          <option selected disabled value="">-- Select Algorithm --</option>
          <option value="md5">MD5</option>
          <option value="sha1">SHA1</option>
          <option value="sha256">SHA256</option>
          <option value="sha512">SHA512</option>
          <option value="crc32">CRC32</option>
          <option value="techVegan">TechVegan</option>
        </select>
      </div>
      <div class="col mb-3">
        <input type="submit" class="btn btn-dark" value="Generate" name="">
      </div>
    </form>
    <div class="col mb-3">
      <textarea class="form-control fw-bold" style="font-size:26px;text-align:center;" readonly><?php echo $encrypt;?></textarea>
      <br>
      <button type="button" class="btn btn-warning"> Total Length <span class="badge bg-dark"><?php echo $length;?></span> </button>
    </div>
    <hr><hr>
    	<br>
        <h4 class="display-4 border-bottom py-4">CRYPTOGRAPHY - ENCRYPT &amp; DECRYPT</h4>
        <form method="post" action="">
        <div class="col mb-3">
        <input type="text" class="form-control" placeholder="Enter any message" name="data" required>
      </div>
      <div class="col mb-3">
        <input type="submit" class="btn btn-danger" value="ENCRYPT" name="CRYPTO">
        <input type="submit" class="btn btn-success" value="DECRYPT" name="CRYPTO">
      </div>
      </form>
      <div class="col mb-3">
      <textarea class="form-control fw-bold" style="font-sizse:26px;text-align:center;" readonly><?php echo $data;?></textarea>
      <br>
      <button type="button" class="btn btn-warning"> Total Length <span class="badge bg-dark"><?php echo $len;?></span> </button>
    </div>
  </div>
</div>
<script src="js/bootstrap.bundle.js" type="text/javascript"></script>
</body>
</html>