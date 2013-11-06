<?php
   require("include/clusterizator.php");
   require("include/menu.php");
   requirecss("include/sliding.css");
   requirejs("include/sliding.js");
   requirejs("include/evaluate_end_set_prnt.js");
   requirejs("include/evaluate_end_set_prnt.css");
   requirejs("include/tools.js");

   clus_head();
   show_menu();
?>

<h1>Tools</h1>

<h2>Linear aggregation analysis</h2>
This tool performs the linear aggregation analysis from
Scolari et al. Molecular BioSystems 7, 878-888 2011. <br /><br />

<a href="analizzatore/cluster.php">Perform the linear aggregation cluster analysis</a>

<span class='hidden'>
<h2>Multifun ontology enrichment test</h2>

(To be written)<br /><br />

<a>Perform the functional classification enrichment test</a>
</span>

<h2>Multiple sliding window histogram</h2>

This tool compares the spatial distribution of two or more data sets by
superimposing the plots of their sliding window histogram along the
chromosome with a user-prescribed window-size.<br /><br />

<a href="analizzatore/sliding.php" >
  Plot multiple sliding-window histograms
</a>



<h2>Local Pearson correlation</h2>

This tool compares the spatial distribution of two data sets by
plotting the local Pearson correlation coefficient between their
sliding-window histograms along the chromosome with a prescribed
window size.<br /><br />

<a href="analizzatore/pearson.php" >Plot the local Pearson correlation</a>


<br /><br />

<h1>Operations with data sets</h1>


<h2>Intersection of multiple data sets and hypergeometric test </h2>

This tool tests the statistical significance of the
intersection between two data sets. It also creates a new
data set as an intersection betwen two existing ones.<br /><br />

<a class="template-href" href="explore/add-hyper.php?username=@@prnt_user@@">
  Intersect data sets
</a>


<h2>Merge lists</h2>

This tool creates a new data set by  merging  two already
existing ones.<br /><br />

<a class="template-href" href="explore/add-merge.php?username=@@prnt_user@@">
  Merge data sets
</a>



<h2>Load a list of genes from file</h2>

This tool allows to load a personal data set as a gene list.<br /><br />

<a class="template-href" href="explore/add-file.php?username=@@prnt_user@@">
  Load a data set from file
</a>

<span class='hidden'>
<h2>List of genes from list of binding sites (or chromosomal loci)</h2>

This tool implements a simple algorithm that generates a gene list out
of a list of binding sites or chromosomal loci.  For example, it can
be used to apply the linear aggregation analysis to CHiP-Chip or
Chip-seq binding site data.<br /><br />

<a>Generate a gene list from a list of loci</a>

<h2>List of genes from known regulons (RegulonDB)</h2>

(To be written)<br /><br />

<a>Generate a data set as the list of genes controlled by
  specified transcription factors</a>

<h2>List of genes from functional categories (MultiFUN)</h2>

(To be written)<br /><br />

<a>Generate a data set from the genes belonging to specified
  functional categories</a>
</span>
<?php
   clus_tail();
?>
