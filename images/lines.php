<?php

/*
Copyright (c) 2010 - Vito Tafuni - vito@vitotafuni.com

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
header('Content-type: image/svg+xml');
echo '<?xml version="1.0" standalone="no"?>'."\n";
?>
<svg onload="drawLines()" width="100%" height="100%" version="1.1" xmlns="http://www.w3.org/2000/svg">
	<script type="text/ecmascript">
	<![CDATA[
		function getRGB(baseRGB){
			/*
			var R = Math.round(baseRGB + Math.random() * 255) % 255;
			var G = Math.round(baseRGB + Math.random() * 255) % 255;
      		var B = Math.round(baseRGB + Math.random() * 255) % 255;
      		return 'rgb('+[R,G,B].join(',')+')';
      		*/
      		baseRGB = Math.round((216*baseRGB)/255)%216; // only 216 web safe colors
			var RGB = [ '00','33','66','99','CC','FF' ];
      		var R = RGB[baseRGB % 6];
			var G = RGB[Math.round(baseRGB/36)];
      		var B = RGB[Math.round(baseRGB/6)%6];
      		return ['#',R,G,B].join('');
		}
		function getStroke(base){ return 1; } //return Math.round(Math.random()*base);
		function getPos(base){
			var pos = [];
			
			pos[0] = Math.min(Math.max(0,Math.round(Math.random() * (100+base*2))-base),100)+'%';
			pos[1] = Math.min(Math.max(0,Math.round(Math.random() * (100+base*2))-base),100)+'%';
			pos[2] = Math.min(Math.max(0,Math.round(Math.random() * (100+base*2))-base),100)+'%';
			pos[3] = Math.min(Math.max(0,Math.round(Math.random() * (100+base*2))-base),100)+'%';
			
			return pos;
		}
		function drawLine(basePos, baseS, baseRGB){
			var pos = getPos(basePos);
			
			var line = document.createElementNS('http://www.w3.org/2000/svg', 'line'); 
			line.setAttribute('x1',pos[0]);
			line.setAttribute('y1',pos[1]);
			line.setAttribute('x2',pos[2]);
			line.setAttribute('y2',pos[3]);
			line.setAttribute('style','stroke:'+getRGB(baseRGB)+';stroke-width:'+getStroke(baseS));
			
			document.getElementById("group").appendChild(line);
		}
		function drawLines(){
			var ip='<?php echo $_SERVER['REMOTE_ADDR'];?>'.split('.');//location.href.substr(location.href.indexOf('=')+1).split('.');
			ip[0]=Math.min(ip[0],255); //secure
			for(var i=0; i<ip[0]; i++)
				drawLine(ip[1],ip[2],ip[3]);	
			
		}
	//]]> </script>
    <g id="group"> </g>
</svg>

