#!/usr/bin/gawk -f
# usage ./disegnaclusters.awk macro clust

# header
BEGIN {
    PI = 3.1415926535;
    size_cm=12;
    size_px=size_cm * 100;

    descr="Graph with clusters and macrodomains";

    print "<?xml version=\"1.0\" standalone=\"no\"?>";
    print "<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.1//EN\"";
    print "  \"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd\">";
    print "<svg width=\"12cm\" height=\"" size_cm "cm\"";
    print "  viewBox=\"-"  size_px/2 " -" size_px/2 " " size_px " " size_px"\"";
    print "  version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\"";
    print "  xmlns:xlink=\"http://www.w3.org/1999/xlink\">";
    print "  <desc>" descr "</desc>";

    print " <pattern id=\"divide\" patternUnits=\"userSpaceOnUse\"";
    print "	   x=\"0\" y=\"0\" width=\"15\" height=\"15\">";
    print "    <g style=\"fill:none; stroke:black; stroke-width:6;\">";
    print "      <path d=\"M15,0 l-15,15\"/>";
    print "      <path d=\"M-5,5 l10,-10\"/>";
    print "      <path d=\"M10,20 l10,-10\"/>";
    print "    </g>";
    print " </pattern>";

    print "  <pattern id=\"slash\" patternUnits=\"userSpaceOnUse\"";
    print "	   x=\"0\" y=\"0\" width=\"15\" height=\"15\">";
    print "    <g style=\"fill:none; stroke:black; stroke-width:6;\">";
    print "      <path d=\"M15,15 l-15,-15\"/>";
    print "      <path d=\"M10,-5 l10,10\"/>";
    print "      <path d=\"M-5,10 l10,10\"/>";
     print "   </g>";
    print "  </pattern>";

    print "  <pattern id=\"thindivide\" patternUnits=\"userSpaceOnUse\"";
    print "	   x=\"0\" y=\"0\" width=\"20\" height=\"20\">";
    print "    <g style=\"fill:none; stroke:black; stroke-width:3;\">";
    print "      <path d=\"M0,20 l20,-20\"/>";
    print "      <path d=\"M-5,5 l10,-10\"/>";
    print "      <path d=\"M15,25 l10,-10\"/>";
    print "    </g>";
    print "  </pattern>";

    print "  <pattern id=\"thinslash\" patternUnits=\"userSpaceOnUse\"";
    print "	   x=\"0\" y=\"0\" width=\"20\" height=\"20\">";
    print "    <g style=\"fill:none; stroke:black; stroke-width:3;\">";
    print "      <path d=\"M20,20 l-20,-20\"/>";
    print "      <path d=\"M15,-5 l10,10\"/>";
    print "      <path d=\"M-5,15 l10,10\"/>";
    print "    </g>";
    print "  </pattern>";

    print "  <pattern id=\"thincross\" patternUnits=\"userSpaceOnUse\"";
    print "	   x=\"0\" y=\"0\" width=\"20\" height=\"20\">";
    print "    <g style=\"fill:none; stroke:black; stroke-width:3;\">";
    print "      <path d=\"M0,20 l20,-20\"/>";
    print "      <path d=\"M20,20 l-20,-20\"/>";
    print "    </g>";
    print "  </pattern>";

#    print "  <rect x=\"-599\" y=\"-599\" width=\"1198\" height=\"1198\""
#    print "        fill=\"none\" stroke=\"blue\" />"
    print

}

# functions
function draw_macrodomain (level, start, end, color)
{
    arco_start = 2 * PI * start * 1e6 / genomelenght;
    arco_end = 2 * PI * end * 1e6 / genomelenght;


    r = size_px/4*(1 - (level)*0.2);
    x_s = r*sin(arco_start);
    y_s = r*-cos(arco_start);
    x_e = r*sin(arco_end);
    y_e = r*-cos(arco_end);
    print "  <path d=\"M" x_s "," y_s
    print "  A " r "," r " " arco_start " 0,1 " x_e "," y_e;
    print "  L " 1.1*x_e "," 1.1*y_e;
    print "  A " 1.1*r "," 1.1*r " " arco_end " 0,0 " 1.1*x_s "," 1.1*y_s;
    print "  z\""
    print "fill=\"" color "\" stroke=\"black\" stroke-width=\"5\" />"

}

function draw_cluster (level, start, end, color)
{
    arco_start=0
    arco_end=0
    arco_start = 2 * PI * start * 1e6 / genomelenght;
    arco_end = 2 * PI * end * 1e6 / genomelenght;
	
	
    r = size_px/4*(1.26 - (level)*.03);
    x_s = r*sin(arco_start);
    y_s = r*-cos(arco_start);
    x_e = r*sin(arco_end);
    y_e = r*-cos(arco_end);
    print "  <path d=\"M 0 0" 
    print "  L " x_s "," y_s
    if (((end - start) * 1e6) < (genomelenght / 2))
	print "  A " r "," r " " arco_start " 0,1 " x_e "," y_e;
    else
	print "  A " r "," r " " arco_start " 1,1 " x_e "," y_e;
    print "  z\""
    print "  fill=\"" color "\" stroke=\"black\" stroke-width=\"2\""
    print "  opacity=\"" level/7 "\"    />"

}

# data reading
! /^#/ {   

    if(FILENAME == ARGV[1])  #### boccard macrodomains
    {
	draw_macrodomain($2, $3, $4, $5);
    }
    else if (FILENAME == ARGV[2])  #### dati clusters
    {
	
	draw_cluster($2, $3, $4, color);
    }
    
}

END {
    print "  <text x=\"-" size_px/3.8 "\" y=\"-" size_px/3.8  "\"" 
    print "  font-family=\"Helvetica\" font-size=\"55\" fill=\"black\" >"
    print "  OriC"
    print "  </text>"
    print "  <text x=\"" size_px/3.8 "\" y=\"" size_px/3.8  "\"" 
    print "  font-family=\"Helvetica\" font-size=\"55\" fill=\"black\" >"
    print "  Ter"
    print "  </text>"

    print "</svg>"

}