<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:sm="http://www.sitemaps.org/schemas/sitemap/0.9">
<xsl:template match="/">
  <html>
  	<head>
    	<title>XML Sitemap</title>
        <style type="text/css">
			body {
				font-family: Helvetica, Arial, sans-serif;
				font-size: 13px;
				color: #545353;
			}
			.expl{line-height:22px; text-align:center;}
			.expl h1{border-bottom:1px solid #ccc; padding-bottom:12px; margin-top:20px;}
			.expl a{text-decoration:none; color:#004080; font-weight:bold;}
			.expl a:hover{text-decoration:underline;}
			table{table-layout:auto; width:100%;}
			table .head th{background-color:#006B9F; color:#FFF;
			font-size:16px; font-family:arial;padding:10px;}
			table a{text-decoration:none; color:#900;}
			table a:hover{color:#000;}
			table tr td{border-bottom:1px solid #ccc; padding:6px;font-size:14px;}
			table tr:nth-child(even) {
				background-color:#EEE;	
			}	
		</style>
    </head>
  <body>
  <div class="expl">
  	<h1>XML Sitemap</h1>
  	<p>
  	This is an XML Sitemap of <a href="https://bintefarooq.com" target="_blank">bintefarooq.com</a> , This is a Blogging Website, developed by <a href="https://bintefarooq.com" target="_blank">bintefarooq.com</a></p>
<p>You can find more information about XML Sitemaps on <a href="http://sitemaps.org" rel="nofollow" target="_blank">sitemaps.org</a>.</p>
</div>
  <table align="center" style="width:100% !important;">
    <tr class="head">
      <th style="width:60%;text-align:left;">URL</th>
      <th style="width:20%">Frequency</th>
      <th style="width:20%">Priority</th>
    </tr>
    <xsl:for-each select="sm:urlset/sm:url">
    	<xsl:variable name="sitemapURL">
        	<xsl:value-of select="sm:loc"/>
       </xsl:variable>
    <tr>
      <td><a href="{$sitemapURL}" target="_blank"><xsl:value-of select="sm:loc"/></a></td>
      <td style="text-align:center;text-transform:uppercase;font-size:12px;">
      	<xsl:value-of select="sm:changefreq"/></td>
      <td style="text-align:center;"><xsl:value-of select="sm:priority"/></td>
    </tr>
    </xsl:for-each>
  </table>
  </body>
  </html>
</xsl:template>
</xsl:stylesheet>