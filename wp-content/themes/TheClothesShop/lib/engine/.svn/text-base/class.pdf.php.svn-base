<?php
	//this class is only called by file class.invoice.php at line 17

	function hex2dec($couleur = "#000000"){
	    $R = substr($couleur, 1, 2);
	    $rouge = hexdec($R);
	    $V = substr($couleur, 3, 2);
	    $vert = hexdec($V);
	    $B = substr($couleur, 5, 2);
	    $bleu = hexdec($B);
	    $tbl_couleur = array();
	    $tbl_couleur['R']=$rouge;
	    $tbl_couleur['G']=$vert;
	    $tbl_couleur['B']=$bleu;
	    return $tbl_couleur;
	}

	//conversion pixel -> millimeter in 72 dpi
	function px2mm($px){
	    return $px*25.4/72;
	}	

	function txtentities($html){
	    $trans = get_html_translation_table(HTML_ENTITIES);
	    $trans = array_flip($trans);
	    return strtr($html, $trans);
	}

	class PDF extends FPDF {
	var $B;
	var $I;
	var $U;
	var $HREF;
	var $fontList;
	var $issetfont;
	var $issetcolor;
		/*
			Colours can be expressed in RGB components or gray scale
			Dimmensions are set in mm
		*/
		
		//Page header
		function Header(){				
			
			global $OPTION;
			
			// the logo 
			$path 	= WP_CONTENT_DIR.'/themes/' . WPSHOP_THEME_NAME . '/images/logo/'.$OPTION['wps_pdf_logo'];			
			
		
			clearstatcache();
			if(file_exists($path) === TRUE){
				$w 	= $OPTION['wps_pdf_logoWidth'];
				$this->Image($path,NULL,NULL,$w); 
			}
			else{
				$this->SetFont('Arial','B',8);
				$this->SetTextColor(225,0,0);
				$this->Cell(75,10,__('Double check your logo image file name under your Shop > PDF settings!','wpShop'),1,0);
			}
											
			$this->SetXY(90,11);	
			
			//print the shop's address 
			if ($OPTION['wps_pdf_header_addr_disable'] == FALSE){
				//the shop's address as saved in the theme settings
				$ad 			= array();
				$ad['f_name']	= stripslashes($OPTION['wps_shop_name']);	
				if ($OPTION['wps_pdf_shop_name_only'] == FALSE) {
					$ad[street]	= $OPTION['wps_shop_street'];
					$ad[zip]	= $OPTION['wps_shop_zip'];
					$ad[town]	= $OPTION['wps_shop_town'];
					$ad[state]	= $OPTION['wps_shop_province'];
					$ad[country]= get_countries(2,$OPTION['wps_shop_country']);
					
					//create shop's address
					$biz_ad = address_format($ad,'bill_header');	
					$biz 	= str_replace("<br/>","\n",$biz_ad);
					$biz	= pdf_encode($biz);
				}
				
				// set font size
				$font_size = $OPTION['wps_pdf_header_fontSize'];
				$this->SetFont('Arial','B',$font_size);
			
				//get the text colour
				$txt_colour = $OPTION['wps_pdf_header_txtColour'];
				$this->SetTextColor($txt_colour);
				
				//do we want a border?
				if ($OPTION['wps_pdf_header_addrBorder']){$border = 1;} else {$border = 0;}
				
				// get the width - default is 0.2mm
				$borderWidth 	= $OPTION['wps_pdf_header_addrBorderWidth'];
				$this->SetLineWidth($borderWidth);
				
				// do we want a background colour?
				if ($OPTION['wps_pdf_header_bgdColour_enable']) {
					//get the bgd colour 
					$bgd_colour = $OPTION['wps_pdf_header_bgdColour'];
					$this->SetFillColor($bgd_colour);
					if ($OPTION['wps_pdf_shop_name_only'] == FALSE) {
						$this->MultiCell(0,7,"$biz",$border,'L',true);//width, height, string to print, no border, align left, fill true
					} else {
						$this->Cell(0,7,"$ad[f_name]",$border,2,'L',true); //for just the Shop's name
					}
					// custom header text
					$OPTION['wps_pdf_header_custom_text'] = "Date: " . date('d-m-Y');
					if ($OPTION['wps_pdf_header_custom_text'] !='') {
						$font_size2 = $font_size - 2;
						$this->SetFont('Arial','',$font_size2);
						$this->Cell(0,7,$OPTION['wps_pdf_header_custom_text'],$border,'R',true);
					}
				} else {
					if ($OPTION['wps_pdf_shop_name_only'] == FALSE) {
						$this->MultiCell(0,9,"$biz",$border,'L'); //width, height, string to print, no border, align left, fill false
					} else {
						$this->Cell(0,7,"$ad[f_name]",$border,2,'L'); //for just the Shop's name
					}
					// custom header text
					if ($OPTION['wps_pdf_header_custom_text'] !='') {
						$font_size2 = $font_size - 2;
						$this->SetFont('Arial','',$font_size2);
						$this->Ln(10);
						$border = 0;
						$this->MultiCell(0,7,date ('m-d-Y'),$border,'R');
					}
				}
			}
			
			// for the happy event that customers order so much that additional pages are necessary...
			$pageNo	= $this->PageNo();
	
			if($pageNo > 1){

				//$this->Ln(25);
				
				$w1 = $OPTION['wps_pdf_colWidth1']; //20;
				$w2 = $OPTION['wps_pdf_colWidth2']; //115 
				$w3 = $OPTION['wps_pdf_colWidth3']; //15 	
				$w4 = $OPTION['wps_pdf_colWidth4']; //20 	
				$w5 = $OPTION['wps_pdf_colWidth5']; //20 	
				$h2	= 3;
				
				$continuation = __('- invoice page:','wpShop') . ' ' . $pageNo . ' -';
				$this->SetFont('Arial','',8);
				$this->Cell(0,6,pdf_encode($continuation),0,1,'R');
				$this->Ln(3);
				
				$this->SetFont('Arial','B',9);
				$this->Cell($w1,6,pdf_encode( __('Item-No:','wpShop')),1,0);
				$this->Cell($w2,6,pdf_encode( __('Item','wpShop')),1,0);
				$this->Cell($w3,6,pdf_encode( __('Qty','wpShop')),1,0);
				$this->Cell($w4,6,pdf_encode( __('Item Price','wpShop')),1,0);
				$this->Cell($w5,6,pdf_encode( __('Item Total','wpShop')),1,1);	
				$this->SetFont('Arial','',9);	
			}
		}

		
		//Page footer
		function Footer()
		{
			global $OPTION;
		
			//Position at xy mm from bottom
			$this->SetY(-20);
			
			// set font size
			$font_size = $OPTION['wps_pdf_footer_fontSize'];
			$this->SetFont('Arial','',$font_size);
			
			if(strlen($OPTION['wps_vat_id']) > 1)
			{
				$vat_id = ' - ' . $OPTION['wps_vat_id_label'].': '.$OPTION['wps_vat_id'];
			}
			else{$vat_id = NULL;}
			
			// the footer text
			//custom text?
			if ($OPTION['wps_pdf_footer_custom_text'] !='') {
				$footer_text = utf8_decode($OPTION['wps_pdf_footer_custom_text']);	
			} else {
				$footer_text = utf8_decode($OPTION['wps_shop_name'] . $vat_id);		
			}
			
			//get the text colour
			$txt_colour = $OPTION['wps_pdf_footer_txtColour'];
			$this->SetTextColor($txt_colour);
			
			//do we want a border?
			if ($OPTION['wps_pdf_footer_Border']){$border = 1;} else {$border = 0;}
			
			// get the width - default is 0.2mm
			$borderWidth 	= $OPTION['wps_pdf_footer_BorderWidth'];
			$this->SetLineWidth($borderWidth);
			
			// do we want a background colour?
			if ($OPTION['wps_pdf_footer_bgdColour_enable']) {
				//get the bgd colour 
				$bgd_colour = $OPTION['wps_pdf_footer_bgdColour'];
				$this->SetFillColor($bgd_colour);
				$this->Cell(0,10,"$footer_text",$border,0,'C',true);
				
			} else {
				$this->Cell(0,10,"$footer_text",$border,0,'C');
			}
			
		}

		function WriteHTML($html)
		{
		    // HTML parser
		    $html = str_replace("\n",' ',$html);
		    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		    foreach($a as $i=>$e)
		    {
		        if($i%2==0)
		        {
		            // Text
		            if($this->HREF)
		                $this->PutLink($this->HREF,$e);
		            else
		                $this->Write(5,$e);
		        }
		        else
		        {
		            // Tag
		            if($e[0]=='/')
		                $this->CloseTag(strtoupper(substr($e,1)));
		            else
		            {
		                // Extract attributes
		                $a2 = explode(' ',$e);
		                $tag = strtoupper(array_shift($a2));
		                $attr = array();
		                foreach($a2 as $v)
		                {
		                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
		                        $attr[strtoupper($a3[1])] = $a3[2];
		                }
		                $this->OpenTag($tag,$attr);
		            }
		        }
		    }
		}

		function OpenTag($tag, $attr)
		{
		    //Opening tag
		    switch($tag){

		        case 'SUP':
		            if($attr['SUP'] != '') {    
		                //Set current font to: Bold, 6pt     
		                $this->SetFont('', '', 6);
		                //Start 125cm plus width of cell to the right of left margin         
		                //Superscript "1" 
		                $this->Cell(2, 2, $attr['SUP'], 0, 0, 'L');
		            }
		            break;

		        case 'TABLE': // TABLE-BEGIN
		            if( $attr['BORDER'] != '' ) $this->tableborder=$attr['BORDER'];
		            else $this->tableborder=0;
		            break;
		        case 'TR': //TR-BEGIN
		            break;
		        case 'TD': // TD-BEGIN
		            if( $attr['WIDTH'] != '' ) $this->tdwidth=($attr['WIDTH']/4);
		            else $this->tdwidth=100; // SET to your own width if you need bigger fixed cells
		            if( $attr['HEIGHT'] != '') $this->tdheight=($attr['HEIGHT']/6);
		            else $this->tdheight=6; // SET to your own height if you need bigger fixed cells
		            if( $attr['ALIGN'] != '' ) {
		                $align=$attr['ALIGN'];        
		                if($align=="LEFT") $this->tdalign="L";
		                if($align=="CENTER") $this->tdalign="C";
		                if($align=="RIGHT") $this->tdalign="R";
		            }
		            else $this->tdalign="L"; // SET to your own
		            if( $attr['BGCOLOR'] != '' ) {
		                $coul=hex2dec($attr['BGCOLOR']);
		                    $this->SetFillColor($coul['R'], $coul['G'], $coul['B']);
		                    $this->tdbgcolor=true;
		                }
		            $this->tdbegin=true;
		            break;

		        case 'HR':
		            if( $attr['WIDTH'] != '' )
		                $Width = $attr['WIDTH'];
		            else
		                $Width = $this->w - $this->lMargin-$this->rMargin;
		            $x = $this->GetX();
		            $y = $this->GetY();
		            $this->SetLineWidth(0.2);
		            $this->Line($x, $y, $x+$Width, $y);
		            $this->SetLineWidth(0.2);
		            $this->Ln(1);
		            break;
		        case 'STRONG':
		            $this->SetStyle('B', true);
		            break;
		        case 'EM':
		            $this->SetStyle('I', true);
		            break;
		        case 'B':
		        case 'I':
		        case 'U':
		            $this->SetStyle($tag, true);
		            break;
		        case 'A':
		            $this->HREF=$attr['HREF'];
		            break;
		        case 'IMG':
		            if(isset($attr['SRC']) and (isset($attr['WIDTH']) or isset($attr['HEIGHT']))) {
		                if(!isset($attr['WIDTH']))
		                    $attr['WIDTH'] = 0;
		                if(!isset($attr['HEIGHT']))
		                    $attr['HEIGHT'] = 0;
		                $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
		            }
		            break;
		        //case 'TR':
		        case 'BLOCKQUOTE':
		        case 'BR':
		            $this->Ln(5);
		            break;
		        case 'P':
		            $this->Ln(10);
		            break;
		        case 'FONT':
		            if (isset($attr['COLOR']) and $attr['COLOR']!='') {
		                $coul=hex2dec($attr['COLOR']);
		                $this->SetTextColor($coul['R'], $coul['G'], $coul['B']);
		                $this->issetcolor=true;
		            }
		            if (isset($attr['FACE']) and in_array(strtolower($attr['FACE']), $this->fontlist)) {
		                $this->SetFont(strtolower($attr['FACE']));
		                $this->issetfont=true;
		            }
		            if (isset($attr['FACE']) and in_array(strtolower($attr['FACE']), $this->fontlist) and isset($attr['SIZE']) and $attr['SIZE']!='') {
		                $this->SetFont(strtolower($attr['FACE']), '', $attr['SIZE']);
		                $this->issetfont=true;
		            }
		            break;
		    }		
		}

		function CloseTag($tag)
		{
		    //Closing tag
		    if($tag=='SUP') {
		    }

		    if($tag=='TD') { // TD-END
		        $this->tdbegin=false;
		        $this->tdwidth=0;
		        $this->tdheight=0;
		        $this->tdalign="L";
		        $this->tdbgcolor=false;
		    }
		    if($tag=='TR') { // TR-END
		        $this->Ln();
		    }
		    if($tag=='TABLE') { // TABLE-END
		        //$this->Ln();
		        $this->tableborder=0;
		    }

		    if($tag=='STRONG')
		        $tag='B';
		    if($tag=='EM')
		        $tag='I';
		    if($tag=='B' or $tag=='I' or $tag=='U')
		        $this->SetStyle($tag, false);
		    if($tag=='A')
		        $this->HREF='';
		    if($tag=='FONT'){
		        if ($this->issetcolor==true) {
		            $this->SetTextColor(0);
		        }
		        if ($this->issetfont) {
		            $this->SetFont('arial');
		            $this->issetfont=false;
		        }
		    }
		}
		function SetStyle($tag, $enable)
		{
		    // Modify style and select corresponding font
		    $this->$tag += ($enable ? 1 : -1);
		    $style = '';
		    foreach(array('B', 'I', 'U') as $s)
		    {
		        if($this->$s>0)
		            $style .= $s;
		    }
		    $this->SetFont('',$style);
		}

		function PutLink($URL, $txt)
		{
		    // Put a hyperlink
		    $this->SetTextColor(0,0,255);
		    $this->SetStyle('U',true);
		    $this->Write(5,$txt,$URL);
		    $this->SetStyle('U',false);
		    $this->SetTextColor(0);
		}		
	}