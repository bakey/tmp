<?php
	function getMsgBodyFromTemplate($para = array()){
		$rhtml = '';
		$rhtml.= '<body marginwidth="0" marginheight="0" bgcolor="#000000" leftmargin="0" topmargin="0"><table height="100%" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#000000"> 	<tr> 		<td valign="top" align="middle"><table width="551" cellspacing="0" cellpadding="0" border="0"> 				<tr>  					<td bgcolor="#ffffff" align="left"><table width="551" cellspacing="0" cellpadding="0" border="0"> 								<tr> 									<td style="PADDING-RIGHT: 0pt; PADDING-LEFT: 0pt; PADDING-BOTTOM: 20px; PADDING-TOP: 0pt" 

               ><table width="100%" cellspacing="0" cellpadding="0" border="0">                       <tr>                         <td align="left"><img height="46" width="93" src="http://www.sendn.com/media/newsletters_thumbs/t1/i/i-01.gif" alt=" " 

                       ></td>                         <td align="right"><img height="46" width="60" src="http://www.sendn.com/media/newsletters_thumbs/t1/i/i-02.gif" alt=" " 

                       ></td>                       </tr>                      </table>                     <table width="551" cellspacing="0" cellpadding="0" border="0"> 											<tr> 												<td style="PADDING-RIGHT: 0pt; PADDING-LEFT: 32px; PADDING-BOTTOM: 0pt; PADDING-TOP: 0pt" 

                     ><img height="30" width="156" src="http://www.sendn.com/media/newsletters_thumbs/t1/i/logo.gif" alt="Yout Company Name" 

                       ></td> 												<td valign="center" align="right" style="FONT-SIZE: 18px; COLOR: rgb(172,171,171); FONT-FAMILY: Arial,Helvetica,sans-serif" 

                      >';
            $rhtml.= date('Y-m-d');
            $rhtml.= '</td> 												<td width="46" valign="top"><img height="18" width="46" src="http://www.sendn.com/media/newsletters_thumbs/t1/i/i-03.gif" alt=" " 

                       ></td>                       </tr> 										</table></td> 								</tr> 								<tr>                 	<td><img height="2" width="551" src="http://www.sendn.com/media/newsletters_thumbs/t1/i/i-04.gif" alt=" " 

                 ></td>                 </tr>                 <tr> 									<td bgcolor="#ce4211" style="BACKGROUND-COLOR: rgb(206,66,17)"  >&nbsp;</td> 								</tr>                 <tr>                 	<td><img height="2" width="551" src="http://www.sendn.com/media/newsletters_thumbs/t1/i/i-05.gif" alt=" " 

                 ></td>                 </tr> 								<tr> 									<td><table width="525" cellspacing="0" cellpadding="0" border="0">  											<tr> 												<td style="PADDING-TOP: 8px"><table width="551" cellspacing="0" cellpadding="0" border="0"> 														<tr> 															<td valign="top"><img height="269" width="335" src="http://www.sendn.com/media/newsletters_thumbs/t1/i/postcard.gif" alt="" 

                             ></td> 															<td width="190" valign="top"><table width="100%" cellspacing="0" cellpadding="0" border="0">                                   <tr>                                     <td style="PADDING-RIGHT: 30px; PADDING-LEFT: 0pt; FONT-SIZE: 12px; PADDING-BOTTOM: 0pt; COLOR: rgb(51,51,51); LINE-HEIGHT: 17px; PADDING-TOP: 0pt; FONT-FAMILY: Arial,Helvetica,sans-serif" 

                               ><p style="FONT-SIZE: 13px; MARGIN: 10px 0pt 8px; COLOR: rgb(51,51,51)" 

                                ><b>Ut wisi enim ad minim</b></p>                                       <p style="MARGIN: 0pt 0pt 10px">Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper                                          suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel                                          eum iriure dolor in hendrerit in vulputate velit esse molestie consequat,                                          vel illum dolore eu feugiat. Duis autem vel eum iriure dolor in hendrerit in.                                         Duis autem vel eum iriure.</p></td>                                   </tr>                                   <tr>                                     <td><img height="20" width="168" src="http://www.sendn.com/media/newsletters_thumbs/t1/i/i-07.gif" alt=" " 

                               ></td>                                   </tr>                                  </table></td> 														</tr> 													</table></td> 											</tr> 											<tr> 												<td style="PADDING-RIGHT: 0pt; PADDING-LEFT: 20px; PADDING-BOTTOM: 20px; PADDING-TOP: 20px" 

                     ><table width="100%" cellspacing="0" cellpadding="0" border="0">                              <tr>                               <td valign="top" style="FONT-SIZE: 14px; COLOR: rgb(0,0,0); LINE-HEIGHT: 20px; FONT-FAMILY: Arial,Helvetica,sans-serif" 

                            ><p style="FONT-SIZE: 16px; MARGIN: 0pt 0pt 10px; COLOR: rgb(1,101,171)" 

                              ><A style="COLOR: rgb(97,164,38)" href="#" target  =_blank ><b>';
        $rhtml.= $para[0];
        $rhtml.= ' : ';
        $rhtml.= '</b></A></p><p style="MARGIN: 0pt 0pt 15px">欢迎加入LibSchool，请点击下边的链接激活您的账户。';
        foreach ($para[1] as $singlepara) {
        	$rhtml.= '<p style="MARGIN: 0pt 0pt 15px">'.$singlepara.'</p>';
        }
        $rhtml.= '</td>                               <td valign="top" style="PADDING-RIGHT: 0pt; PADDING-LEFT: 0pt; PADDING-BOTTOM: 0pt; PADDING-TOP: 30px" 

                           ><img height="185" width="51" src="http://www.sendn.com/media/newsletters_thumbs/t1/i/i-08.gif" alt=" " 

                             ></td>                             </tr>                            </table></td> 											</tr> 										</table></td> 								</tr>                 <tr>                 	<td><img height="19" width="551" src="http://www.sendn.com/media/newsletters_thumbs/t1/i/i-09.gif" alt=" " 

                 ></td>                 </tr>  								<tr> 									<td style="BACKGROUND-COLOR: rgb(228,228,228)" 

                ><table width="100%" cellspacing="0" cellpadding="0" border="0">                       <tr>                         <td width="18" valign="bottom" style="PADDING-RIGHT: 2px; PADDING-LEFT: 0pt; PADDING-BOTTOM: 0pt; PADDING-TOP: 0pt" 

                     ><img height="33" width="18" src="http://www.sendn.com/media/newsletters_thumbs/t1/i/i-10.gif" alt=" " 

                       ></td>                         <td valign="top" style="FONT-SIZE: 12px; COLOR: rgb(102,102,102); LINE-HEIGHT: 17px; FONT-FAMILY: Arial,Helvetica,sans-serif" 

                      ><p style="MARGIN: 0pt 0pt 10px"><b>Your Company Name</b><br 

                        >                              123 Your Address, Your City, State, Zip<br >                             <A style="COLOR: rgb(64,137,187)" href="mailto:info@yourcompany.com" target  =_blank >info@yourcompany.com</A><br 

                        >                             <a target="_blank" href="http://www.yourcompany.com" style="COLOR: rgb(64,137,187)" 

                        >www.yourcompany.com</a></p></td>                         <td width="82" valign="bottom"><img height="27" width="82" src="http://www.sendn.com/media/newsletters_thumbs/t1/i/i-11.gif" alt=" " 

                       ></td>                       </tr>                      </table></td> 								</tr> 							</table></td> 				</tr> 			</table></td> 	</tr> </table></body>';
        return $rhtml;

	}
?>