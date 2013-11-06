<?php

require("../include/clusterizator.php");
require("include/menu.php");

clus_head();
show_menu();

?>


<img src="../images/logo.png" alt="Geno_logo" id="geno-logo" />
UMR 7238 CNRS <br/> Universite Pierre et Marie Curie

<div id="big-title">
  <h1>NuST@<a href="http://www.lgm.upmc.fr">Genomique des Microorganismes<a/>  </h1> 
</div>


<h1>  Learn by example: interpreting the results and choosing the parameters. </h2> 

  </div>
   <h2 class="likesectionHead"><a 
 id="x1-1000"></a>Contents</h2>
   <div class="tableofcontents">

   <span class="sectionToc" >1 <a 
href="#x1-10001" id="QQ2-1-1">Introduction</a></span>


<br />   <span class="sectionToc" >2 <a 
href="#x1-10002" id="QQ2-1-2">Linear aggregation analysis
</a></span>


<br />  <span class="sectionToc" >3 <a 
href="#x1-10003" id="QQ2-1-3">Multiple sliding window histograms</a></span>



<br />  <span class="sectionToc" >4 <a 
href="#x1-10004" id="QQ2-1-4">Local Pearson correlation</a></span>
   </div>


<br />  <span class="sectionToc" >5 <a 
href="#x1-10005" id="QQ2-1-5">Credits</a></span>
   </div>









<!--l. 31--><p class="noindent" >
   <h2 class="sectionHead"><span class="titlemark">1   </span> <a 
 id="x1-10001"></a>Introduction</h2>


This help page guides the user through interpreting the results
obtained by the different tools and how to choose the parameters,
related to different observation scales. As an example, we chose some
data sets from the recent literature. <br/>



<p class="noindent" >
   <h2 class="subsubsectionHead"><span class="titlemark">2   </span> <a 
 id="x1-10002"></a>Learn by example: linear aggregation analysis</h2>



The linear aggregation analysis is automatically performed at
different observation scales (i.e. different number of bins). This
feature is essential to allow comparison with nucleoid-related
structures that can involve chromosomal sectors of different length,
like supercoiling domains with a typical length of 10 kilobases
(Postow et al Genes Dev 18, 1766-79 2004) or macrodomains that span
megabases.  Increasing the number of bins allows the observation of
linear aggregation clusters at finer scales. However, at the smallest
scale available (1024 bins) the bin size is of the order of the
typical gene length, thus the presence of clusters could just be the
consequence of the operon organization of the genes in the list, since
the operon structure is not preserved in the null model used to asses
the significance of linear aggregation. As a general rule of thumb,
the number of bins should not exceed significantly the number of genes
in the list in analysis and the results must be carefully interpreted
considering the scale of observation used.

 <br/> <br/> Given these general considerations, the user can be
interested specifically in global localization patterns at a specific
scale, depending on the biological question at hand. For instance, a
coarse-grained view of the chromosome, given by a number of bins
between 4 and 16, can be useful to identify significant localization
of a gene set in early- or late-replicating regions, or the possible
preferential positioning inside a specific macrodomain.  The desired
observation scale can be selected using the sliding bars in the page
of the linear aggregation analysis tool (a description of the output
format can be found <a href="index.php#x1-80002.2.2">here<a/>).  The
statistically significant gene clusters obtained using a number of
bins between a minimal (left sliding-bar) and maximal (right
sliding-bar) value can be drawn on the circular chromosome. <br/>

As an illustrative case, a global bias of sigma-factor target
positions on the chromosome has been recently shown (Sobetzko et al
PNAS 109, E42-50 2012): the vegetative sigma factor 70 has a higher
target density near the origin of replication, while the
stationary-phase sigma factor 38 presents an opposite bias. This
large-scale trend can be shown performing the linear aggregation
analysis on the two common data sets "Genes regulated by the sigma
factor 70 (from Regulon DB)" and "Genes regulated by the sigma factor
38 (from Regulon DB)" present in the internal database, using an
appropriate (small) number of bins (from 4 to 8 in this example):

<br/>

<br/>


<table border="0"  width="100%" align="left">
<tr><TD>
<div align="left"><img src="sigma_example.png" width="750" border="3" style="border-color: blue" ></div>

<br/>

Since this is a large-scale bias, it becomes less clearly visible
using a higher number of bins.<br/>  <br/> 

In other cases, increasing the number of bins can highlight additional
useful information. As discussed in (Scolari et al. Molecular
BioSystems 7, 878-888 2011), clusters of genes whose expression is
affected by deletion of either Fis or H-NS and upon changes in
negative supercoiling, identified in different experiments, appear to
overlap well with the Ter macrodomain at large scale, while the
analysis at smaller scales shows a preferential localization towards
the edges of the macrodomain. This is the type of results that can be
extracted making full use of the multi-scale analysis offered by the
linear aggregation tool.  For example, performing the linear
aggregation analysis on the common dataset "H-NS knockout sensitive
genes under negative-supercoiling (from Blot et al 2006)" and
representing the significative clusters from a large scale (4 bins) to
a smaller scale (128 bins) shows both the statistical clustering in
the Ter macrodomain and the preference for the Ter macrodomain edges:
<br/>


 <br/>

<table width="100%" align="left">
<tr><TD>
<div align="left"><img src="multiscale.png" width="650" border="3" style="border-color: blue"></div>

<br/>




<br /> <br />
  &nbsp;&nbsp; <a href="#x1-1000" id="QQ2-1-4">TOP</a>
<br /> 




<p class="noindent" >
   <h2 class="subsubsectionHead"><span class="titlemark">3  </span> <a 
 id="x1-10003"></a>Learn by example: multiple sliding window histograms</h2>

Sliding window histograms allow a graphical visualization of gene
densities along the genome. The resulting representation depends on
the observation scale selected by the user by changing the number of
bins with the sliding bar in the output page (described in
detail <a href="index.php#x1-80002.3.2">here<a/> ).  While one can be
guided by the linear aggregation clusters found for a gene set, there
is no general rule for choosing an appropriate observation scale for
studying and comparing gene density profiles from different input
lists. The selected observation scale should reflect the specific
biological question of the user and the results need to be interpreted
accordingly.  However, as a first qualitative criteria, the number of
bins should be sufficiently low to avoid a mere representation of gene
and operon positions. In fact, if the plot appears as "spikes"
alternated with zero density regions, and the number of genes in the
density peaks is just few units or even one (provided the "Normalize?"
option is not selected), the plot is just showing single gene
positions and their operon organization, as in this example:

 <br/>


<br/>
<table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="many_bins_multiple.png" width="450"border="3" style="border-color: blue"></div>

<br/>      

<br/> Decreasing the number of bins can give a more relevant
representation of possible gene aggregation at larger scales, for the
same data set:



<br/>
<table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="few_bins_multiple.png" width="450"border="3" style="border-color: blue"></div>
<br/>      


A lower bin number makes the size of the sliding window used to
 evaluate the gene density larger. Hence, the plot typically looks
 smoother.  

<br/> <br/> 



Similar considerations hold if multiple sliding window histograms are
used to compare gene density profiles of different gene lists. A
number of bins that is too large could show the mere co-occurrence of
the same gene/operon in the two lists. If the user is interested in
such small-scale information it could be more appropriate to use the
hypergeometric test implemented in NuST, which gives immediately the
statistical significance of the intersection between the two lists
(the hypergeometric test in NuST is
described <a href="index.php#x1-30002.2.3">here<a/> ).  

However, two gene lists can have a null intersection while presenting
similar gene density profiles if observed at the right scale. In this
case, the multiple sliding window histograms can be a useful tool to
explore a range of possible observation scales (changing the number of
bins), visually inspecting the results for possible profile
similarities.  In order to perform a more quantitative of the
correlation between two gene density profiles at a certain observation
scale, the Pearson correlation analysis described in the following
section can be used.<br/>



<br /> <br />
  &nbsp;&nbsp; <a href="#x1-1000" id="QQ2-1-4">TOP</a>
<br /> 


<p class="noindent" >
   <h2 class="subsubsectionHead"><span class="titlemark">4   </span> <a 
 id="x1-10004"></a> Learn by example: local Pearson correlation</h2>

The Pearson correlation analysis allows the user to calculate the
correlation between gene density profiles along the chromosome of two
input gene lists. In particular, the global Pearson correlation
(reported on the top-right of the output plot) and its local version
(the curve in the output plot) can be evaluated (a description of the
output format can be
found <a href="index.php#x1-80002.4.2">here<a/>). 

This analysis is quite delicate, as both quantities are heavily
influenced by the observation scale as the gene density profiles are
dependent on the number of bins.  For instance, two lists can show a
relatively high global correlation on a large scale, but almost no
correlation on smaller scales. This is the case for the two lists
"Genes regulated by the sigma factor 70 (from Regulon DB)" and "Genes
regulated by the sigma factor 38 (from Regulon DB)" present in the
internal database. As recently discussed (Sobetzko et al PNAS 109,
E42-50 2012), the target genes of this two sigma factors are
preferentially located in a large region proximal to the replication
origin (Ori) and the replication terminus (Ter)
respectively. Therefore, anticorrelation between their density
profiles is expected at large scales. However, since in these broad
regions their genes are not positioned in mutually exclusive clusters,
almost no correlation is observed on smaller scales. A a result, the
global Pearson (given by the top-right legend in the plots) shows
anticorrelation using 4 bins, but the signal is lost increasing the
bin number:
<br/>

<br/>
<table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="sigma_pearson.png" width="550" border="3" style="border-color: blue"></div>
<br/>


The local Pearson correlation represented in the plots shows the
relative contributions of the different chromosomal regions to the
value of the global Pearson correlation between the density
profiles. Note that its absolute value does not have a statistical
meaning on its own and it is not bounded between -1 and 1 (as the
global Pearson correlation). However, it is a quantitative way to
compare different chromosomal sectors and extrapolate the locally
highly (anti)correlated regions where the gene densities concurrently
deviate from their mean values, thus considerably contributing to the
global correlation or anticorrelation depending on whether the
deviations are on the same or opposite direction.
<br/>  <br/> 

As a second example of application of the local Pearson correlation
analysis, we consider two sets of putative H-NS targets obtained in
different groups using different experimental techniques: "Putative
H-NS target genes in stationary phase from ChIP-seq
experiments (from Kahramanoglou et al 2010)" and "Putative H-NS target
genes from ChIP-chip experiments (from Oshima et al 2006)" in the
common database. As expected, the two lists present both a significant
intersection (tested using the hypergeometric test
described <a href="index.php#x1-30002.2.3">here<a/>) and globally
correlated gene density profiles:<br/>

<br/>
<table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="hns_pearson.png" width="550" border="3" style="border-color: blue"></div>
<br/>
    
The chromosomal regions with high local Pearson coefficient correspond
to genomic sectors where both experiments found coherently a
higher-than-average or a lower-than-average density of targets, thus
the regions predominantly determining the global positive
correlation. Note however that within a region with good correlation,
but where the values of the two densities that are compared are both
close to their global average, the local Pearson will be smaller than
in equally correlated regions that are far from the global averages.




<br /> <br />
  &nbsp;&nbsp; <a href="#x1-1000" id="QQ2-1-4">TOP</a>
<br /> 



<p class="noindent" >
   <h2 class="sectionHead"><span class="titlemark">4 </span> <a 
 id="x1-10005"></a>Credits </h2>


Vittore F Scolari (vittore.scolari_at_upmc.fr) <br /> <br />

Mina Zarei <br /> 
Matteo Osella <br /> 
Marco Cosentino Lagomarsino <br /> <br />

<a href="http://www.lgm.upmc.fr/drupal/?q=node/82">
Genophysique / Genomic Physics Group<a/> 
<br />
UMR 7238 CNRS Universite Pierre et Marie Curie<br />
Paris, France<br />

<img src="../images/HFSP-100-blue.png" alt="HFSP_logo" id="HFSP-logo" style="width: 50px;"/> Grant RGY-0069/2009-C

<?php
clus_end();
?>
