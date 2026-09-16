<?php 
/*
  * @package component kwpsolarsystem for Joomla! 5.x 6.x
 * @version $Id: kwpsolarsystem 1.0.0 2026-05-05 01:10:10Z $
 * @author KWProductions Co.
 * @copyright (C) 2022- KWProductions Co.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of kwpsolarsystem.
    kwpsolarsystem is free software: you can redistribute it and/or adify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    kwpsolarsystem is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for are details.
    You should have received a copy of the GNU General Public License
    along with kwpsolarsystem.  If not, see <http://www.gnu.org/licenses/>.
 
*/

?>
<?php
/**
 * @package     com_kwpsolarsystem
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\Component\Kwpsolarsystem\Site\Helper\DatetimeHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
HTMLHelper::_('jquery.framework');

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();

$params=json_decode($this->item->params);
//var_dump($params);
//exit();
$slides = str_replace("|qq|", "\"", $params->slides);
$slides = json_decode($slides);

	    $noConflict = "var bq = jQuery.noConflict();";
        $wa->addInlineScript($noConflict);
	$prehelions = [];
	$aphelions = [];
	$prehelions [] =1;
	$aphelions [] =1;
	$planetwidths=[0, 8, 12, 15, 12, 24, 21, 18, 14, 8];
		$planetheights=[0, 8, 12, 15, 12, 24, 21, 18, 14, 8];
					$uranus = [];
					$imgwidths = [];
					$imgheights =[];
					$imgwh = [];
                    $imgsun;
	
        foreach($slides as $i=>$itm):
        
	     $images[]=Uri::base().$itm->imgname;	
		//  $texts[]=$itm->imgcaption;
	//var_dump($itm->imgtitle);
									//	var_dump($itm->imgcaption);	
          		if($i!=0){
									
		  $prehelions[]=(float) $itm->imgtitle;
		  $aphelions[]=(float)  $itm->imgcaption;
		  $imgwh [] =  $itm->imglink;
				}  else{
			  $imgsun =  $itm->imglink;
			//  var_dump($itm->imglink);
				}		   
        endforeach;
				  $sunsize = explode("-",$imgsun);
				  $sunw = $sunsize[0];
				 $sunh = $sunsize[1];
				//  var_dump($imgsun);
				//  var_dump($sunh);
				//  exit();

		$k=1;
		foreach($imgwh as $i=>$wh)
		{
			$arr = explode("-", $wh);
	//	var_dump($arr[0]."-".$arr[1]);
			$imgwidths[$k]=$arr[0];
			$imgheights[$k]=$arr[1];
			$k++;
		}
		//var_dump($imgwh);
	//	exit();
	
		
		
		$flagp=0;
		
		for($i=0; $i<count($prehelions); $i++)
		{
			for($j=$i; $j<count($prehelions); $j++)
			{
				if($prehelions[$i]>$prehelions[$j])
				{
					$flagp=1;
					break;
				}
			}
		}
		$flaga=0;
		for($i=0; $i<count($aphelions); $i++)
		{
			for($j=$i; $j<count($aphelions); $j++)
			{
				if($aphelions[$i]>$aphelions[$j])
				{
					$flaga=1;
					break;
				}
			}
		}
		//add checking for all of them to be at the same length or alert.The  first one is considered as Sun.
		$P=[];
		$T=[];
		$e=[];
		$a=[];
		$c=[];
		$planetsmass = [];
		
		$P =[0, 30, 70, 100, 152, 520, 950, 1920, 3010, 5000];
		$T[]=1;
		$e[]=1;
		$a[]=1;
		$c[]=1;
		$planetsmass=[0, 0.056, 0.817, 1, 0.108, 318.36, 95.22, 14.58, 17.26, 0.88];
		
		$radius = [];
		$x = [];
		$y = [];
		
		$radius[]=1;
		$x[]=1;
		$y[]=1;
		
		
		$solarpositiony;
		$solarpositionx;
		
		
		
		
		
		$framepiece=[];
		
				for($i=1; $i<count($images); $i++)
				{
					

								$a[$i] = ($prehelions[$i]+$aphelions[$i])/2;
								//var_dump($a[$i]);
								$c[$i] = ((2*$a[$i])- (2*$prehelions[$i]))/2;
								if($a[$i]!=0)
								$e[$i] = $c[$i]/$a[$i];
						//	var_dump($e[$i]);
							//	$rad[$i] = ($aphelions[$i]-$prehelions[$i])/12;
								$radius[$i]=array(11);
								$x[$i] = array(11);
								$y[$i]=array(11);

				}
				
				
			$solarpositionx = (int) $params->solar_left ;
				$solarpositiony = (int) $params->solar_top ;
	//		if(count($prehelions)===count($a)):	
				
				$phi=0;
			for($i=1; $i<count($images); $i++)
			{
				$phi = 0;
				for($j=0; $j<=5; $j++)
				{
					
					
					if($j==0)
					{
						$radius[$i][$j]= (int) $prehelions[$i];
						$radius[$i][10]=(int) $prehelions[$i];
											//	var_dump($radius[$i][$j]);

					}
					else
						if($j==5)
						{
								$radius[$i][$j]= (int) $aphelions[$i];
														//var_dump($radius[$i][$j]);

						}
						else
							if($j>0 && $j<5)
					{
						$phi+=M_PI/5;
						$radius[$i][$j] =  ($a[$i]) /  (1 +( $e[$i] * cos($phi)) );
					    switch($j)
						{
							case 1:
							   $radius[$i][9]=$radius[$i][$j];
							  break;
							  case 2:
							   	$radius[$i][8]=$radius[$i][$j];
							  break;
							  case 3:
							   	$radius[$i][7]=$radius[$i][$j];
							  break;
							  case 4:
							      $radius[$i][6]=$radius[$i][$j];
							  break;
							  
						}
					}
				}
			}
		/*for($i=1; $i<count($images); $i++)
			{
				for($j=0;$j<11;$j++)
				{
					var_dump($radius[$i][$j]);
				}
				exit();
			}*/
			
			for($i=1; $i<count($images); $i++)
			{
				$phi=0;
				for($j=0; $j<=5; $j++)
				{
						if(cos($phi)<0)
								$x[$i][$j]= $radius[$i][$j] * cos($phi) * (-1);
							else
					              $x[$i][$j]= $radius[$i][$j] * cos($phi);
				                
								if($j<5)
										$y[$i][$j]= $radius[$i][$j] * sin($phi);
									else
										$y[$i][$j]=0;
										

								
				/*if($i==1)
				{					
					var_dump($x[$i][$j]);
					var_dump($y[$i][$j]);
				}*/
					
				//	var_dump($phi);

					$phi+=M_PI/5;
				}
				//exit();
			}
			//var_dump("richess, suck.");
			
			for($i=1; $i<count($images); $i++)
			{
				
				for($j=0; $j<=5; $j++)
				{
					if($j==0)
					{
						$x[$i][$j]= ($solarpositionx - $x[$i][$j]) ;					
						$y[$i][$j]=$solarpositiony ;
						$x[$i][10]=$x[$i][$j];
						$y[$i][10]=$y[$i][$j];
					}
					else
					if($j>0 && $j<=2)
					{
						$x[$i][$j]=($solarpositionx - $x[$i][$j]) ;
						$y[$i][$j]=$solarpositiony - $y[$i][$j];
					}
					else
						if($j>2 && $j<5)
					    {
						 $x[$i][$j]=($solarpositionx + $x[$i][$j]) ;
						 $y[$i][$j]=$solarpositiony - $y[$i][$j];
					    }
						else
							if($j==5)
							{
									 $x[$i][$j]=($solarpositionx + $x[$i][$j]);
									 $y[$i][$j]=$solarpositiony ;
							}
						
						  switch($j)
						{
							case 1:
							   $x[$i][9]=$x[$i][$j] ;
							   $y[$i][9]= $solarpositiony + $y[$i][$j];
							  break;
							  case 2:
							   	$x[$i][8]=$x[$i][$j] ;
							    $y[$i][8]= $solarpositiony + $y[$i][$j];
							  break;
							  case 3:
							   	$x[$i][7]=$x[$i][$j] ;
								 $y[$i][7]= $solarpositiony + $y[$i][$j];
							  break;
							  case 4:
							      $x[$i][6]=$x[$i][$j] ;
								  $y[$i][6]= $solarpositiony + $y[$i][$j];
							  break;
							  
						}
						
						
				}
			//	exit();
			}
	//	exit();	
	/*		
			
	for($i=1; $i<count($images); $i++)
			{
				
		for($j=0; $j<10; $j++)
				{
				//	var_dump($i."----".$j);
			if($i==3){
					var_dump($x[$i][$j]);
										var_dump($y[$i][$j]);
				}

					
				}
				if($i==3)
				{
					var_dump($solarpositionx);
				     exit();
				}
			}*/
		//	exit();
			
			/*
				for($i=1; $i<count($images); $i++)
				{
					$a[$i] = $a[$i]/100;
				}*/
			//	var_dump($radius[1][1]);
				//var_dump(cos(M_PI/5));
		//	exit();
			//	var_dump($a[1]);
			//	var_dump($a[2]);
		
		//No.zero is for the sun.
		
		
					$uranus = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
			//	$uranusangle = 0;
				$aofuranus = ($prehelions[7]+$aphelions[7])/2;
				
		for($i=0; $i<=5; $i++)
		{
			
			if($i==0)
							$uranus[$i]= $solarpositiony + ( $radius[7][$i] * 1 );
						else
						if($i<5){
                                   $cosphi = ($aofuranus - $radius[7][$i])/($radius[7][$i]*$e[7]);
								   $cp = 1 - pow($cosphi, 2); 
								   $sinphi = pow($cp, 0.5);
								   
		          	$uranus[$i]= $solarpositiony - ( $radius[7][$i] * $sinphi );
						}
		    else
				   $uranus[5] = ($solarpositiony - ($radius[7][0]) ) * (-1);
			   
			   
			switch($i)
			{
				case 0:
				   $uranus[5] = $uranus[0] - ( $radius[7][0] * 1 );
				   $uranus[10] = $uranus[0];
				break;
				case 1:
				   	$uranus[9] =  $solarpositiony + (($radius[7][1] * $sinphi ) - (( $radius[7][1] * $sinphi) * 2) * cos((M_PI*97.5)/180)); ;
				break;
				case 2:
				   	$uranus[8] =  $solarpositiony + (($radius[7][2] * $sinphi ) - (( $radius[7][2] * $sinphi) * 2) * cos((M_PI*97.5)/180));
				break;
				case 3:
				   	$uranus[7] =  $solarpositiony + (($radius[7][3] * $sinphi ) - (( $radius[7][3] * $sinphi) * 2) * cos((M_PI*97.5)/180));
				break;
				case 4:
				    $uranus[6] = $solarpositiony + (($radius[7][4] * $sinphi ) - (( $radius[7][4] * $sinphi) * 2) * cos((M_PI*97.5)/180));
				break;
			
			}
		//	$uranusangle += M_PI/5;
		//	var_dump($solarpositiony);
		}
		
		for($i=0; $i<11; $i++)
		{
			//var_dump($x[7][$i]);
		  $uranus[$i] =	$uranus[$i]/10;
		  //$x[7][$i]= $x[7][$i]/8;
		  var_dump($uranus[$i]);
		}
		
		//exit();
		
		
		
		for($i=1; $i<count($images); $i++)
		{
			//$P[$i]= ($prehelions[$i]+$aphelions[$i])/2;
					//	var_dump($P[$i]);

			$P[$i] = pow($P[$i], 2);
			$T[$i] = pow($P[$i], 0.3333) ;
			///var_dump($T[$i]);
			//var_dump($e[$i]);
			$framepiece[$i] ="
			
			
                 @property --angle".$i."
                 {
	               syntax: '<angle>';
	               inherits: true;
	                initial-value:0deg;
                 }
                @property --z".$i."
                {
	               syntax: '<integer>';
	               inherits: true;
	               initial-value:1.0;
                }
                @property --bk".$i."
                {
                   syntax: '<string>';
                   inherits:false;
                    initial-value:'blue';
                }
			
				@property --xamp".$i."
                {
	               syntax: '<length>';
	               inherits: true;
	               initial-value:93px;
                }
				@property --yamp".$i."
                {
	               syntax: '<length>';
	               inherits: true;
	               initial-value:93px;
                }
			
				
				
               :root
                {
                     --bk:".$params->solarbackgroundcolor.";
                 }
            
			
			   @keyframes revolve".$i."
               {
	                0%  {  --xamp".$i.":".$x[$i][0]."px;    --yamp".$i.":".$y[$i][0]."px;  --angle".$i.":0deg;    --z".$i.":10;}
				    10%  {   --xamp".$i.":".$x[$i][1]."px;    --yamp".$i.":".$y[$i][1]."px;  --angle".$i.":36deg;    --z".$i.":10;}
					20%  {   --xamp".$i.":".$x[$i][2]."px;    --yamp".$i.":".$y[$i][2]."px;   --angle".$i.":72deg;    --z".$i.":10;}
				    30%  {   --xamp".$i.":".$x[$i][3]."px;    --yamp".$i.":".$y[$i][3]."px;    --angle".$i.":108deg;    --z".$i.":10;}
					 40%  {   --xamp".$i.":".$x[$i][4]."px;    --yamp".$i.":".$y[$i][4]."px;    --angle".$i.":144deg;    --z".$i.":10;}
				    50%  {   --xamp".$i.":".$x[$i][5]."px;    --yamp".$i.":".$y[$i][5]."px;    --angle".$i.":180deg;    --z".$i.":1;}
					60%  {   --xamp".$i.":".$x[$i][6]."px;    --yamp".$i.":".$y[$i][6]."px;  --angle".$i.":216deg;    --z".$i.":1;}
				    70%  {   --xamp".$i.":".$x[$i][7]."px;    --yamp".$i.":".$y[$i][7]."px;   --angle".$i.":252deg;    --z".$i.":1;}
					 80%  {   --xamp".$i.":".$x[$i][8]."px;    --yamp".$i.":".$y[$i][8]."px;    --angle".$i.":288deg;    --z".$i.":1;}
				    90%  {   --xamp".$i.":".$x[$i][9]."px;    --yamp".$i.":".$y[$i][9]."px;    --angle".$i.":324deg;    --z".$i.":1;}
					100%  {   --xamp".$i.":".$x[$i][10]."px;    --yamp".$i.":".$y[$i][10]."px;   --angle".$i.":360deg;    --z".$i.":1;}             

              }
			
          .moon".$i."
          {		 
		position:absolute;
		
		
	         --x".$i.":calc( var(--xamp".$i.") * cos(var(--angle".$i.")) );
		       --y".$i.":calc( var(--yamp".$i.")  *  sin(var(--angle".$i.")));
			   translate:var(--xamp".$i.") 0 var(--yamp".$i.");
		    
		       z-index:calc(var(--z".$i."));
		      animation:revolve".$i." ".$T[$i]."s linear infinite;
			  width:".$imgwidths[$i]."px;
			  height:".$imgheights[$i]."px;
			  top: ".$solarpositiony+($sunh/3)."px;
		

	
            }
			
			
			
			";
			$wa->addInlineStyle($framepiece[$i]);
		}
		
		$uranusvar = "
			
			@property --hamp
                {
	               syntax: '<length>';
	               inherits: true;
	               initial-value:93px;
                }
			
			@keyframes uranus 
			{
				  0%  {--xamp7:".$x[7][0]."px;   --hamp:".$uranus[0]."px; --yamp7:".$y[7][0]."px; }
				    10%  {--xamp7:".$x[7][1]."px;  --hamp:".$uranus[1]."px; --yamp7:".$y[7][1]."px;  }
					20%  {--xamp7:".$x[7][2]."px;   --hamp:".$uranus[2]."px; --yamp7:".$y[7][2]."px;  }
				    30%  { --xamp7:".$x[7][3]."px;  --hamp:".$uranus[3]."px; --yamp7:".$y[7][3]."px;  }
					 40%  {--xamp7:".$x[7][4]."px;   --hamp:".$uranus[4]."px; --yamp7:".$y[7][4]."px; }
				    50%  {--xamp7:".$x[7][5]."px;   --hamp:".$uranus[5]."px;  --yamp7:".$y[7][5]."px; }
					60%  {--xamp7:".$x[7][6]."px;   --hamp:".$uranus[6]."px;  --yamp7:".$y[7][6]."px; }
				    70%  {--xamp7:".$x[7][7]."px;   --hamp:".$uranus[7]."px;  --yamp7:".$y[7][7]."px; }
					 80%  {--xamp7:".$x[7][8]."px;   --hamp:".$uranus[8]."px;  --yamp7:".$y[7][8]."px; }
				    90%  {--xamp7:".$x[7][9]."px;    --hamp:".$uranus[9]."px; --yamp7:".$y[7][9]."px; }
					100%  {--xamp7:".$x[7][10]."px;    --hamp:".$uranus[10]."px;  --yamp7:".$y[7][10]."px; }  
			}
			
			.moon7
			{
							   translate:var(--xamp7) var(--hamp) var(--yamp7) ;
							   		      animation:uranus ".$T[7]."s linear infinite;


			}
			
			";
						$wa->addInlineStyle($uranusvar);

		
	//	endif;
		//$p = ($prehelions[0]+$aphelions[0])/2;
		
	/*	var_dump($images);
		var_dump($prehelions);
		var_dump($aphelions);*/
	//	exit();


?>
<style type="text/css">
header
{
	display:none;
}
.solarcontainer
{
	/*perspective:1200px;*/

	width:100%;
	height:100%;
}
.solarsystem
{
	position:relative;
	background-color:<?php echo $params->solarbackgroundcolor; ?>;
	left:0px;
	top:0px;
				width: <?php echo $params->solar_width; ?>px ;
		height:<?php echo $params->solar_height; ?>px;
	/*	transform:rotateX(45deg);*/

		overflow:hidden;


}
.sun 
{
	position:relative;
	
		left:<?php echo $solarpositionx - ($sunw/2) ?>px;
				top:<?php echo $solarpositiony ?>px;

		/*width:53px;
		height:53px;*/
			z-index:5;

		
}
.sun img
{
	position:absolute;
	width:<?php echo $sunw; ?>px;
		height:<?php echo $sunh; ?>px;
	
}
</style>


<?php if ($this->params->get('show_page_heading')) : ?>
    <div class="page-header">
        <h1>
			<?php if ($this->escape($this->params->get('page_heading'))) : ?>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			<?php else : ?>
				<?php echo $this->escape($this->params->get('page_title')); ?>
			<?php endif; ?>
        </h1>
    </div>
<?php endif; ?>

<?php 
        if($flagp==1 || $flaga==1)
			echo "<h1> The Perihelions or The Aphilions you input in your Backsite are not in ascending order, Fix it.</h1>";
		else{
	?>
	<div class="solarcontainer" >
         <div id="solarsystem" class="solarsystem">
		 				<div class="sun"><img src="<?php echo $slides[0]->imgname; ?>" /></div>

		 <?php
		 	for($i=1; $i<count($images); $i++)
	    	{
				?>
				
<div class="moon<?php echo $i;  ?>" ><img   src="<?php echo $slides[$i]->imgname; ?>" width="25px" height="25px" /></div>
			<?php 
			}
		 ?>
         </div>
		 
	</div>	 
		<?php }
    




