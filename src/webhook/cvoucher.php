								$misi	= file_get_contents("./webhook/dvoucher.php");
								$misi0	= explode("#",$misi);
								for ($i=0 ; $i < count($misi0)-1 ; $i++) {
									$misi1=$misi0[$i];
									$misi2=explode("*",$misi1);
									if (trim($misi2[0])==$_GET['router']){
										for ($a=1 ; $a < count($misi2) ; $a++) {
											$misi3=explode("|",$misi2[$a]);
//											echo "<option>".$a."--".$misi3[0]."</option>";
											echo "<option value='./?hotspot=whreport&idtele=".$idtele."&mtgl3=".$mtgl3."&router=".$router."&paket=".$misi3[0]."&session=".$session . "'>" . $misi3[0] . "</option>";
										}
									}
								}
