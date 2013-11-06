<?php

require("include/clusterizator.php");
require("include/menu.php");

clus_head();
show_menu();

?>
<img src="images/HFSP-100-blue.png" alt="HFSP_logo" id="HFSP-logo" style="float:right; width: 50px;"/>

<img src="images/logo.png" alt="Geno_logo" id="geno-logo" />
UMR 7238 CNRS <br/> Universite Pierre et Marie Curie

<div id="big-title">
  <h1>
Nucleoid Survey Tools
  <br/>
NuST@<a href="http://www.lgm.upmc.fr">Genomique des Microorganismes<a/>  </h1> 
</div>




<h2>About</h2> 

This website contains a set of tools and data sets that can be used to analyze the aggregation of a set of genes along the genome coordinate, at
different scales of observation.   It is based for the moment on the <i>Escherichia coli</i> genome. 
<br /><br />

It is useful to discover correlations between different sources of
data (e.g. expression, binding, or genomic data) and genome
organization. It implements most of the analyses performed in ref. (Scolari et al. 
Molecular BioSystems 7, 878-888 2011) 
on arbitrary data sets, using a web interface and improved algorithms.  <br /><br />

  <!--
The main engine analyzes the spatial distribution of a gene list
against a shuffling null model and produces a plot with the
significant linear-aggregation clusters ad different scales of
analysis. It can also produce a sliding-window histogram of the data
and a sketch of the cluster arrangements of the circular genome.  <br
/><br />

Different sliding window histograms can be overlayed, and compared
using the local Pearson correlation coefficient. <br />
<br />

You can analyze our database of data sets from published studies, or
add data sets in the form of gene or loci lists from your own
experiments or bioinformatic analyses. <br /> <br />


Some additional tools allow to generate gene-based data sets from loci
lists, by selecting functional annotations, and by using interactions
from the RegulonDB E. coli transcription network data set. <br /> <br
/>
-->

<h2>
  <a href="help/">How to use NuST (Help pages)</a>
/
  <a href="help/example.php">Learn by example</a>
</h2>



<h2>
  <a href="tools.php">Start the analysis</a>
</h2>


<h2>
  <a href="explore/">Explore the database</a>
</h2>


<h2>
  <a href="upload/">Upload a data set</a>
</h2>


<h2>
  <a href="downloads/">Downloads</a>
</h2>




<h2>Credits</h2> 
Vittore F Scolari (vittore.scolari_at_upmc.fr) <br /> 

Mina Zarei <br /> 
Matteo Osella <br /> 
Marco Cosentino Lagomarsino <br /> <br />

<strong>Citation<br />
  NuST: analysis of the interplay between nucleoid organization
  and gene expression.</strong> <i>Bioinformatics</i>. 2012 Jun 15;28(12):1643-4. doi:
<a href="http://dx.doi.org/10.1093/bioinformatics/bts201">10.1093/bioinformatics/bts201</a>
<br /><br />

<strong>See also<br /></strong>
V. F. Scolari, B. Bassetti, B. Sclavi and M. Cosentino Lagomarsino.
<strong>
  Gene clusters reflecting macrodomain structure respond to nucleoid perturbations.
</strong> <i>Molecular BioSystems</i>. 7.3 (2011):878-888. doi:
<a href="http://dx.doi.org/10.1039/C0MB00213E">10.1039/C0MB00213E</a><br />
M. Zarei, B. Sclavi and M. Cosentino Lagomarsino.
<strong>
  Gene silencing and large-scale domain structure of the E. coli genome.
</strong> <i>Molecular BioSystems</i>. (2013). doi:
<a href="http://dx.doi.org/10.1039/C3MB25364C">10.1039/C3MB25364C</a>
<br /><br />

<a href="http://www.lgm.upmc.fr/drupal/?q=node/82">
Genophysique / Genomic Physics Group<a/>
<br />
UMR 7238 CNRS Universite Pierre et Marie Curie<br />
Paris, France<br />

<img src="images/HFSP-100-blue.png" alt="HFSP_logo" id="HFSP-logo" style="width: 50px;"/> Grant RGY-0069/2009-C

<?php
clus_end();
?>
