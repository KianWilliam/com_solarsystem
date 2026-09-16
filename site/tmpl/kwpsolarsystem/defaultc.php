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
	
        foreach($slides as $i=>$itm)
        { 
	      $images[]=Uri::base().$itm->imgname;	
		//  $texts[]=$itm->imgcaption;	
		  $prehelions[]=$itm->imgtitle;
		  $aphelions[]=$itm->imgcaption;
        }
		//add checking for all of them to be at the same length or alert.The  first one is considered as Sun.
		$P=[];
		$T=[];
		$e=[];
		$a=[];
		$c=[];
		
		$radius = [];
		$xradius = [0];
		$yradius = [0];
		
		
		
		$framepiece=[];
		
				for($i=1; $i<count($images); $i++)
				{
								$a[$i] = ($prehelions[$i]+$aphelions[$i])/2;
								$c[$i] = ((2*$a[$i])- (2*$prehelions[$i]))/2;
								$e[$i] = $c[$i]/$a[$i];
								$rad[$i] = ($aphelions[$i]-$prehelions[$i])/12;
								$radius[$i]=array(6);
								$xradius[$i] = array(6);
								$yradius[$i]=array(6);

				}
				$phi=0;
			for($i=1; $i<count($images); $i++)
			{
				$phi = 0;
				for($j=0; $j<=5; $j++)
				{
					
					
					if($j==0)
					{
						$radius[$i][$j]= (int) $prehelions[$i];
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
						//var_dump($radius[$i][$j]);
					}
				}
			}
			for($i=1; $i<count($images); $i++)
			{
				$phi=0;
				for($j=0; $j<=5; $j++)
				{
					$xradius[$i][$j]= $radius[$i][$j] * cos($phi);
					$yradius[$i][$j]= $radius[$i][$j] * sin($phi);

					$phi+=M_PI/5;
				}
			}
			
		/*for($i=1; $i<count($images); $i++)
			{
				
			for($j=0; $j<=5; $j++)
				{
					var_dump($i."----".$j);
					var_dump($xradius[$i][$j]);
										var_dump($yradius[$i][$j]);

					
				}
			}
			exit();*/
			
			
				for($i=1; $i<count($images); $i++)
				{
					$a[$i] = $a[$i]/100;
				}
			//	var_dump($radius[1][1]);
				//var_dump(cos(M_PI/5));
		//	exit();
			//	var_dump($a[1]);
			//	var_dump($a[2]);
		
		//No.zero is for the sun.
		for($i=1; $i<count($images); $i++)
		{
			$P[$i]= ($prehelions[$i]+$aphelions[$i])/2;
			$P[$i] = pow($P[$i], 2);
			$T[$i] = pow($P[$i], 0.3333);
			/*var_dump($P[$i]);
			var_dump($T[$i]);
			var_dump($e[$i]);*/
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
				@property --a".$i."
                {
	               syntax: '<number>';
	               inherits: true;
	               initial-value:0.0;
                }
			    @property --e".$i."
                {
	               syntax: '<number>';
	               inherits: true;
	               initial-value:0.0;
                }
				  @property --ecc".$i."
                {
	               syntax: '<number>';
	               inherits: true;
	               initial-value:0.0;
                }
				  @property --ae".$i."
                {
	               syntax: '<number>';
	               inherits: true;
	               initial-value:0.0;
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
				@property --rad".$i."
                {
	               syntax: '<double>';
	               inherits: true;
	               initial-value:0.0;
                }
					@property --r".$i."
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
	                0%  {  --xamp".$i.":".$x[$i][0]."px;    --yamp".$i.":".$y[$i][0]."px;  --angle".$i.":0deg;    --z".$i.":-1;}
				    10%  {   --xamp".$i.":".$x[$i][1]."px;    --yamp".$i.":".$y[$i][1]."px;  --angle".$i.":36deg;    --z".$i.":-1;}
					20%  {   --xamp".$i.":".$x[$i][2]."px;    --yamp".$i.":".$y[$i][2]."px;   --angle".$i.":72deg;    --z".$i.":-1;}
				    30%  {   --xamp".$i.":".$x[$i][3]."px;    --yamp".$i.":".$y[$i][3]."px;    --angle".$i.":108deg;    --z".$i.":-1;}
					 40%  {   --xamp".$i.":".$x[$i][4]."px;    --yamp".$i.":".$y[$i][4]."px;    --angle".$i.":144deg;    --z".$i.":-1;}
				    50%  {   --xamp".$i.":".$x[$i][5]."px;    --yamp".$i.":".$y[$i][5]."px;    --angle".$i.":180deg;    --z".$i.":-1;}
					60%  {   --xamp".$i.":".$x[$i][4]."px;    --yamp".$i.":".$y[$i][4]."px;  --angle".$i.":216deg;    --z".$i.":-1;}
				    70%  {   --xamp".$i.":".$x[$i][3]."px;    --yamp".$i.":".$y[$i][3]."px;   --angle".$i.":252deg;    --z".$i.":-1;}
					 80%  {   --xamp".$i.":".$x[$i][2]."px;    --yamp".$i.":".$y[$i][2]."px;    --angle".$i.":288deg;    --z".$i.":-1;}
				    90%  {   --xamp".$i.":".$x[$i][1]."px;    --yamp".$i.":".$y[$i][1]."px;    --angle".$i.":324deg;    --z".$i.":-1;}
				    100%  {   --xamp".$i.":".$x[$i][0]."px;    --yamp".$i.":".$y[$i][0]."px;   --angle".$i.":0deg;    --z".$i.":-1;}             
              }
			
          .moon".$i."
          {		 
		
		
		
	         --x".$i.":calc( var(--xamp".$i.") * cos(var(--angle".$i.")) );
		       --y".$i.":calc( var(--yamp".$i.")  *  sin(var(--angle".$i.")));
		      translate: var(--x".$i.") var(--y".$i.");
		       z-index:calc(var(--z));
		      animation:revolve".$i." ".$T[$i]."s linear infinite;
		

	
            }
			
			
			";
			$wa->addInlineStyle($framepiece[$i]);
		}
		
		
		//$p = ($prehelions[0]+$aphelions[0])/2;
		
	/*	var_dump($images);
		var_dump($prehelions);
		var_dump($aphelions);*/
	//	exit();


?>


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


         <div id="solarsystem" class="solarsystem">
		 				<div style="margin-left:75px; margin-top:125px;">Earth</div>

		 <?php
		 	for($i=1; $i<count($images); $i++)
	    	{
				?>
				
<div class="moon<?php echo $i;  ?>" ><?php echo $slides[$i]->imgname; ?></div>
			<?php 
			}
		 ?>
         </div>
    




