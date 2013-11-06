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


<h1>Getting Started with NuST
/
  <a href="example.php">Learn by example</a>
</h1>

  </div>
   <h2 class="likesectionHead"><a 
 id="x1-1000"></a>Contents</h2>
   <div class="tableofcontents">

   <span class="sectionToc" >1 <a 
href="#x1-20001" id="QQ2-1-2">Introduction</a></span>


<br />   <span class="sectionToc" >2 <a 
href="#x1-30002" id="QQ2-1-3">How to use and create data sets
</a></span>

<br />   &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsectionToc" >2.1 <a 
href="#x1-30002.1" id="QQ2-1-44">Upload a data set</a></span>


<br />   &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsectionToc" >2.2 <a 
href="#x1-30002.2" id="QQ2-1-4">Explore the database</a></span>

<br />   &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsectionToc" >2.2.1 <a 
href="#x1-30002.2.1" id="QQ2-1-45">Common and personal data sets</a></span>

<br />   &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsectionToc" >2.2.2 <a 
href="#x1-30002.2.2" id="QQ2-1-5">Add a data set of genes from file </a></span>

<br />   &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsectionToc" >2.2.3 <a 
href="#x1-30002.2.3" id="QQ2-1-6">Create a new data set from intersection or union of data sets</a></span>




<br />  <span class="sectionToc" >3 <a 
href="#x1-70002" id="QQ2-1-7">Tools</a></span>


<br />  &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsectionToc" >3.1 <a 
href="#x1-80002.1" id="QQ2-1-8">Starting a data analysis</a></span>




<br />  &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsectionToc" >3.2 <a 
href="#x1-80002.2" id="QQ2-1-9">Linear aggregation analysis</a></span>

<br />  &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsubsectionToc" >3.3.1 <a 
href="#x1-80002.2.1" id="QQ2-1-10">Tool documentation</a></span>

<br />  &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsubsectionToc" >3.3.2 <a 
href="#x1-80002.2.2" id="QQ2-1-11">Output format</a></span>





<br />  &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsectionToc" >3.3 <a 
href="#x1-80002.3" id="QQ2-1-12">Multiple sliding window histograms</a></span>

<br />  &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsubsectionToc" >3.3.1 <a 
href="#x1-80002.3.1" id="QQ2-1-13">Tool documentation</a></span>

<br />  &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsubsectionToc" >3.3.2 <a 
href="#x1-80002.3.2" id="QQ2-1-14">Output format</a></span>





<br />  &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsubsectionToc" >3.4 <a 
href="#x1-80002.4" id="QQ2-1-15">Compare histograms using local Pearson correlation</a></span>

<br />  &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsubsectionToc" >3.4.1 <a 
href="#x1-80002.4.1" id="QQ2-1-16">Tool documentation</a></span>

<br />  &#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;<span class="subsubsectionToc" >3.4.1 <a 
href="#x1-80002.4.2" id="QQ2-1-17">Output format</a></span>




<br />  <span class="sectionToc" >4 <a 
href="#x1-120004" id="QQ2-1-12">Downloads</a></span>
   </div>




<br />  <span class="sectionToc" >5 <a 
href="#x1-120005" id="QQ2-1-13">Credits</a></span>
   </div>





<!--l. 31--><p class="noindent" >
   <h2 class="sectionHead"><span class="titlemark">1   </span> <a 
 id="x1-20001"></a>Introduction</h2>

NuST (Nucleoid Survey Tools) is a set of tools that can be used for the analysis of the aggregation of specific gene sets along the chromosome, at different observation scales. 

The main engine analyzes the spatial distribution of a gene list
against a shuffling null model and produces a plot with the
significant linear-aggregation clusters at different scales of
analysis. It can also produce a sliding-window histogram of the data
and a sketch of the cluster arrangements of the circular genome.  <br
/><br />

Different sliding window histograms can be overlayed, and compared
using the local Pearson correlation coefficient. <br />
<br />
 
The user can add data sets in the form of gene lists coming from his own experiments or bioinformatic analyses or
 make use of our database of data sets from published studies. This collection of  data is not only a benchmark to test the various tools implemented in the web server, it also represents a valuable database for comparisons with user-defined lists of genes 
<br /> <br />

The web server is currently based on <i>Escherichia coli</i>, since it is the best studied model organism in the bacteria kingdom, for which detailed information on both gene expression and chromosomal organization is available. We are planning to extend the web server to other bacterial species in the near future.
<br /> <br />


This help page guides the user step-by-step through the analyses that can be performed using the NuST web server.


<br /> <br />
  &nbsp;&nbsp; <a href="#x1-1000" id="QQ2-1-4">TOP</a>
<br /> 



<p class="noindent" >
   <h2 class="sectionHead"><span class="titlemark">2   </span> <a 
 id="x1-30002"></a>How to use and create data sets</h2>

<p class="noindent" >
   <h3 class="subsectionHead"><span class="titlemark">2.1   </span> <a 
 id="x1-30002.1"></a> Upload a data set</h3>

A direct link in the NuST <a href="../">Home<a/> page allows the user to directly  <a href="../upload">Upload a data set<a/>  to be analyzed. <br><br/>

<table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="upload.png" width="550" border="3" style="border-color: blue" ></div>
<br><br /> 

The NuST web server requires as input data set a single column text file with one gene ID for each row. <br>
Three <a href="../upload/Sample_data_sets.zip">sample data sets<a/> are given as an example of valid inputs. The sample zip archive contains the three gene lists and a README text file with information about the gene lists. These data sets can be uploaded and used to start the analysis and to test all the available analysis tools. 

<br />
We considered as standard gene ID the gene name given by the Regulon DB database (<a href="http://regulondb.ccg.unam.mx/index.jsp">http://regulondb.ccg.unam.mx<a/> 
). 

If a different gene ID 
(as a Blattner ID) is present in the user list or if a gene ID appears multiple times, the web server will propose the possible synonyms for each non-standard ID 
and give the user the possibility to eliminate possible redundancies. Here is an example of the output for a list containing eight Blattner IDs and 
a repeated gene name:<br><br /> 

<table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="synonyms.png" width="450" border="3" style="border-color: blue"></div>
<br><br /> 

The complete list of gene IDs with their chromosomal coordinates and the list of possible synonyms that the web server can recognize can be downloaded in the <a href="../downloads">Downloads<a/> section.<br> <br/>

After an input file has been correctly uploaded, the analysis can be directly started by clicking the links that automatically appear.  <br><br/>  
The loaded data sets are stored as personal data sets in the internal database described in section 2.2 and can be accessed during the session in the <a href="../explore">Explore<a/> page (menu on top of each page) for further analysis .
The personal data sets are deleted at the end of each anonymous session. If the user needs to keep the data for multiple session a login is needed. This can be obtained sending an email to the administrator (see the "Credits"  section).


<p class="noindent" >
   <h3 class="subsectionHead"><span class="titlemark">2.2   </span> <a 
 id="x1-30002.2"></a> Explore the database</h3>

<p class="noindent" >
   <h4 class="subsectionHead"><span class="titlemark">2.2.1   </span> <a 
 id="x1-30002.2.1"></a> Common and personal data sets</h4>

The  <a href="../explore">Explore<a/> page (which can be selected form the menu on top of each page) presents two different classes of data sets.<br> <br/>

<table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="explore2.png" width="550" border="3" style="border-color: blue"></div>

<br/>
<b>Personal data sets: </b> This is the list of input files loaded by the user. The user can add his/her data sets and delete previously loaded ones. <br> <br/>

Selecting the "Add" tab, three options are available:<br><br /> 


<table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="add_dataset.png" width="650" border="3" style="border-color: blue"  ></div>

<br><br/>

The different options are described in detail below, in sections 2.2.2 and 2.2.3.<br><br /> 


  <b>Common data sets: </b>  This part contains published data, which we collected in an internal static database, representing results from different experiments or external databases. Different tools implemented in the web server allow direct comparison of user-defined data sets with existing ones in this database.

Each data set has the form of a gene list and the data sets are organized in folders in relation to the types of biological data and the experimental techniques. All the information about the data sources, how gene list are extracted  and the reference papers are shown when a data set is selected, by clicking on its name.
</li>

<p class="noindent" >
   <h4 class="subsectionHead"><span class="titlemark">2.2.2   </span> <a 
 id="x1-30002.2.2"></a> Add a data set of genes from file</h4>

A new list of genes can be added as a single column text file with one gene ID for each row. The accepted genes IDs are discussed in section 2.1. Each common data set can be taken as an example of valid input file (selecting the "Show data set" option in the page relative to each data set) or alternatively three <a href="../upload/Sample_data_sets.zip">sample data sets<a/> are given as further examples.   <br/>
The loaded data sets are deleted at the end of each anonymous session. If the user needs to keep the data for multiple session a login is needed. This can be obtained sending an email to the administrator (see the "Credits"  section).


<p class="noindent" >
   <h4 class="subsectionHead"><span class="titlemark">2.2.3   </span> <a 
 id="x1-30002.2.3"></a>Create a new data set from intersection or union of data sets </h4>

										  A new data set can be created intersecting existing lists in the common database or in the personal data sets. As the intersection between the two selected lists is taken,  the result of a hypergeometric test (assessing the statistical significance of the intersection) is printed. The P-value represents the probability of obtaining an intersection of the given size selecting two random gene lists (of the same length of the lists in consideration) from the total number of genes in the genome. <br/>

The figure below illustrates the output from the intersection of two lists in the common database:

<br><br /> 

 <table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="hypergeometric.png" width="550" border="3" style="border-color: blue"></div>
<br><br /> 

Equally, a new data set can be created by merging existing data sets. 

<br /> <br />
  &nbsp;&nbsp; <a href="#x1-1000" id="QQ2-1-4">TOP</a>
<br /> 


<p class="noindent" >
   <h2 class="subsectionHead"><span class="titlemark">3   </span> <a 
 id="x1-70002"></a>Tools</h2>



 <p class="noindent" >
   <h3 class="subsectionHead"><span class="titlemark">3.1   </span> <a 
 id="x1-80002.1"></a>Starting a data analysis </h3>

The different tools that perform data analysis can be accessed in two ways.

<ul>
<li>The user can select a data set in the database and choose one of the three main analysis tools proposed by clicking on it. <br>
As an example, the figure below is the page corresponding to a data set in the common database

<br><br /> 
<div align="left"><img src="example_dataset.png" width="550" border="3" style="border-color: blue"></div>
<br><br /> 

The three tools available for the analysis are connected to the links at the bottom of the page. <br><br />

<li>  All the implemented tools can be used from the <a href="../tools.php">Tools<a/> page (top menu).


The figure below is a snapshot of the Tools page 
<br><br /> 
<div align="left"><img src="tools.png" width="550" border="3" style="border-color: blue"></div>

<br><br />

The following sections describe the different types of analysis and their output formats.
<br><br />

</ul> 

 <p class="noindent" >
   <h3 class="subsectionHead"><span class="titlemark">3.2   </span> <a 
 id="x1-80002.2"></a>Linear aggregation analysis </h3>

 <p class="noindent" >
   <h4 class="subsubsectionHead"><span class="titlemark">3.2.1   </span> <a 
 id="x1-80002.2.1"></a>Tool documentation </h4>


  The linear aggregation analysis is a statistical method for identifying sets of genes belonging to a data set that show significant aggregation along the genomic coordinate. This method considers the density of genes at different scales on the genome using grids of different bin sizes, and compares empirical data with results from random null models. In order to avoid spurious effects of binning, for each gene list a density histogram is built by using a sliding window with a given bin-size. The resulting plot of the averaged density of genes for every point of the circular chromosome is considered at different observation scales of the genome, i.e. at different bin sizes of length  <i>b<sub>s</sub></i> in <i>{L/2,L/4,. . .,L/2^n}</i> where <i>L</i> is the length of
the chromosome. We chose <i>n=10</i>, as <i>b<sub>s</sub></i> < <i>L/1024</i> is close to the scale
of the typical gene length.<br/> <br/>
Density peaks with a significantly high number of genes are identified by comparing empirical data with 10.000 realizations of a null model. For every bin size, the null model considers the density histogram from a random list of the same length of the empirical one. The number of genes for every bin in the empirical histogram is compared to the distribution of global maxima of the null model, obtaining a P-value for the value of the empirical histogram for each bin. This procedure enables the extraction of a list of statistically significant (P &lt;0.01) bin positions. The web server computes the null model realizations only the first time that a data set is seen, in order to avoid unnecessary computation. For each bin-size (or observation scale), clusters are defined as connected intervals containing a significantly high proportion of the genes in the list. The lowest P-value among the merged bins is assigned to each cluster.   The algorithm was previously presented in ref. (Scolari et al. Molecular BioSystems 7, 878-888 2011), where additional information can be found. <br/> <br/>

The procedure for detecting one dimensional aggregation of genes can be summarized as follows.

<br><br /> 
<div align="left"><img src="linear_aggregation_procedure.png" width="400" border="3" style="border-color: blue"></div>

<br>
1) A data set (gene list) loaded by the user is taken as input.<br/>
 2) Using a sliding-window of fixed size, the gene density is evaluated along the chromosome. <br/>
3) A sliding-window density histogram associates to every coordinate on the circular genome the number of genes in the empirical list in an interval surrounding the point and spanning  the fixed bin size. The density at each chromosomal coordinate is
 compared with the P-value thresholds from the null model in order to obtain the significant positions, which are in turn merged with a
compatibility threshold of size <i>b<sub>s</sub></i>  in order to define the clusters. The null model calculates the absolute peaks in the gene density of randomized gene sets of the same size as the empirical one.<br/> <br/>
The three steps of the procedure are repeated for the different bin sizes <i>b<sub>s</sub></i> in <i>{L/2,L/4,. . .,L/2^n}</i> in order to obtain the significant clusters at multiple observation scales. The results are reported in different formats as described in the following section (3.2.2). 

 

<p class="noindent" >
   <h4 class="subsubsectionHead"><span class="titlemark">3.2.2   </span> <a 
 id="x1-80002.2.2"></a>Output format </h4>

The output of the linear aggregation analysis is directly visualized on the web site as two bitmap pictures and a table. The top panel shows the significant clusters for the different observation scales, with a color code representing their P-value. The plot can be saved in two alternative formats (pdf file or file in the <a href="http://plasma-gate.weizmann.ac.il/Grace/">grace</a> plotting program format).

The figure below is an example of cluster diagram resulting from the linear aggregation analysis, for a data set in the common database. The x axis identifies the given observation scale (identified by the bin size of the grid) and the y axis draws the clusters as boxes, as a function of the genomic coordinate, with color coded P-values. The larger bars indicate confidence intervals, and the right panel reports the positions of chromosomal macrodomains and segments, and of a few important genes.  <br/>

<br/>

<table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="linear_aggregation.png" width="450" border="3" style="border-color: blue"></div>

<br/>

The cluster positions can be compared with the location of nucleoid macrodomains. The macrodomain locations are reported in the first vertical bar, as defined in the follwong references; (i)  Valens et al EMBO J 23,4330-4110 2004 ; (ii) Boccard et al.  Mol Microbiol 57, 9-16 2005 ; (iii)  Espeli et al. J Struct Biol 156,  304-10 2006.<br/>
 The exact positions used here are:<br/>

<br/>
<table border="0" width="100%" align="left">
<tr><TD>

<div align="left"><img src="macrodomains_coordinates.png" width="350" border="3" style="border-color: blue"></div>

<br/>



The second vertical bar indicates the coordinates of the chromosome sectors defined by Mathelier and Carbone (Mol Syst Biol 6, 366 2010), with positions: <br/>

<br/>

<table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="mathelier_coordinates.png" width="550" border="3" style="border-color: blue"></div>

<br/>

 The position of well-studied genes (such as "crp" or "fis") is also shown for reference. <br/>


<br/>
<br/>

 A second graphical representation of results is presented in the bottom panel of the page, together with a table summarizing the results:<br/>

<br/>


<table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="linear_aggregation2.png" width="550" border="3" style="border-color: blue"></div>

<br/>



The statistically significant clusters are represented on the circular chromosome as colored wedges whose trasparency increases with size.
The outer colored circle represents macrodomains, while the inner colored circle contains the chromosome sectors defined by Mathelier and Carbone. <br/>
The user can change on-line the range of bin-sizes and update the image and the corresponding table.<br/> <br/>
In the table, the five columns reports respectively: <br/>

<ul>
<li>an ID associated to the cluster (first column); <br/>
<li>the scale of observation (given by the number of bins) at which it is found (second column); <br/>
<li>the cluster start (third column) and stop (fourth column) coordinates in megabases (module the genome length 4.63965 Mb); <br/>
<li>the P-value associated to the cluster (fifth column). 
</ul>

The results can be downloaded as a pdf image, a svg (also in a black and white version),
and as a text file. 
The text file is tab-separated with 5 columns with the results reported in the table visualized on-line. <br/>

<br/>
Follow this <a href="example.php#x1-10002">link</a> for help choosing the parameters and interpreting the results through an example.

<br /> <br />
  &nbsp;&nbsp; <a href="#x1-1000" id="QQ2-1-4">TOP</a>
<br /> 


 <p class="noindent" >
   <h3 class="subsectionHead"><span class="titlemark">3.3  </span> <a 
 id="x1-80002.3"></a> Multiple sliding window histograms</h3>


<p class="noindent" >
   <h4 class="subsubsectionHead"><span class="titlemark">3.3.1   </span> <a 
 id="x1-80002.3.1"></a>Tool documentation </h4>


The sliding window histogram shows the gene density along the genome at different scales of observation.  Given a user-defined window size, the number of genes falling inside the window is counted, while the window slides along the genome stepwise with step size around 500bp (smaller than the typical gene length).<br/>

Multiple histograms for different data sets can be overlaid, in order to easily visualize the presence of domains of co-occurrence or mutual exclusion.  

<br/>
<p class="noindent" >
   <h4 class="subsubsectionHead"><span class="titlemark">3.3.2   </span> <a 
 id="x1-80002.3.2"></a>Output format </h4>

The graphical output represents the number of genes located inside a window centered in each chromosomal position. The window size is fixed by the user-defined bin number. 
</br>


Several data sets can be plotted together, allowing direct comparison of gene densities. It is possible to normalize the gene count (y-axes), which is useful when comparing gene lists of different length. The image below is an example of the overlaid histogram of two data sets in the common database <br/>




<br/>


<table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="multiple_sliding.png" width="450" border="3" style="border-color: blue"></div>

<br/>

The color of each sliding window histogram can be selected using the menu next to the corresponding dataset name. <br/>

The output can be downloaded in different formats (pdf, <a href="http://plasma-gate.weizmann.ac.il/Grace/">grace</a> or a text file with the raw results).<br/>

The text file is a tab-separated file with two columns. 
The first column is the chromosomal starting position of the window and the second column shows the number of genes that fall inside the window.  <br/>

<br/>
Follow this <a href="example.php#x1-10003">link</a> for help choosing the parameters and interpreting the results through an example.


<br /> <br />
  &nbsp;&nbsp; <a href="#x1-1000" id="QQ2-1-4">TOP</a>
<br /> 


 <p class="noindent" >
   <h3 class="subsectionHead"><span class="titlemark">3.4  </span> <a 
 id="x1-80002.4"></a>Compare histograms using local Pearson correlation </h3>



<p class="noindent" >
   <h4 class="subsubsectionHead"><span class="titlemark">3.4.1   </span> <a 
 id="x1-80002.4.1"></a>Tool documentation </h4>

This tool evaluates the local contribution to the Pearson correlation coefficient along the chromosome  between the gene densities of two input lists. <br/>
										  
Essentially, the quantity (x<sub>i</sub></i> - &#60x&#62) (y<sub>i</sub></i> -&#60 y &#62) /(&#963<sub>x</sub></i> &#963<sub>y</sub></i>) is calculated for each window position i, where   x<sub>i</sub></i> and y<sub>i</sub></i> are the signals (gene densities) of the x and y data sets respectively, evaluated inside the window  in position i. On the other hand, averages and standard deviations are calculated  across the whole genome. Therefore, while the global Pearson correlation coefficient is a number between -1 (linear anticorrelation) and +1 (linear correlation), the local product does not have this constraint, but the number still represents a measure of positive or negative correlation. Note that the global Pearson correlation coefficient can change with observation scale, as the sliding window histograms may become different.

<br/>



<p class="noindent" >
   <h4 class="subsubsectionHead"><span class="titlemark">3.4.2   </span> <a 
 id="x1-80002.4.2"></a>Output format </h4>

In the output plot, a black line represents the local contribution to the Pearson correlation coefficient along the genome coordinate
(x-axis) between the normalized linear densities of the two input data sets. The top-right of the plot reports the total Pearson correlation coefficient.
 The window size used to calculate the gene density can be changed on-line by the user by changing the number of bins.</br>
The figure below illustrates the output of this analysis<br/>

<br/>


<table border="0" width="100%" align="left">
<tr><TD>
<div align="left"><img src="pearson.png" width="450" border="3" style="border-color: blue"></div>

<br/>


  The output has selectable colors, and can be downloaded in different formats ( <a href="http://plasma-gate.weizmann.ac.il/Grace/">grace</a>, pdf, black&white pdf or a text file with the raw results). <br/>

The text file is a tab-separated file with two columns. The first column is the chromosomal starting position of the window, while the second column shows the local Pearson correlation between the gene densities of the two lists inside the window. <br/>
<br/>



Follow this <a href="example.php#x1-10004">link</a> for help choosing the parameters and interpreting the results through an example.

<br /> <br />
  &nbsp;&nbsp; <a href="#x1-1000" id="QQ2-1-4">TOP</a>
<br /> 



 <p class="noindent" >
   <h2 class="sectionHead"><span class="titlemark">4  </span> <a 
 id="x1-120004"></a>Downloads </h2>

In the <a href="../downloads">Downloads<a/> page, the user can download the following items. <br/>

<ul>
<li> <a href="../downloads/position.txt">Gene ID with chromosome position<a/>: a tab-separated text file with the standard gene ID (first column), and the start (second column) and stop (third column) coordinates.<br><br/>
<li>  <a href="../downloads/synonim.txt">Gene ID synonym table<a/>: a file with all the synonyms that are recognized by the web server in the form of a single-column text file listing all the pairs synonym&standardID.<br> <br/>

<li>  <a href="../upload/Sample_data_sets.zip">Sample input data sets<a/>: three examples of valid input lists that can be uploaded to start the analysis and test all the available analysis tools, and a README text file with all the information about the sample gene lists.<br> <br/>

<li> <a href="../downloads/nust.pl">Template access perl code<a/>: 
an example of perl script that allows to query the server and download data in different formats. The script is extensively commented and can be extended to produce general codes that systematically access the web server to upload data sets, perform analyses and download analyzed data.  
<br><br/>
</ul> 

<p class="noindent" >
   <h2 class="sectionHead"><span class="titlemark">5  </span> <a 
 id="x1-120005"></a>Credits </h2>


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
