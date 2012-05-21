<table border="0" cellpadding="5" cellspacing="0" width="100%" align="left">

	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			
			{main_menu}
			
		</td>
	</tr>

	<!--tr>
		<td align="left" valign="top" height="20" style="width:100%;" colspan="3">


			{path}


		</td>
	</tr-->
	<tr>
		<td colspan="3">


			<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left" style="border-collapse:collapse;">

				<tr class="tblheader">
					<td>{phrases.settings.columns.title}</td>
					<td>{phrases.settings.columns.column_name}</td>
					<td>{phrases.settings.columns.description}</td>
					<td>{phrases.settings.columns.column_type}</td>
					<td>{phrases.settings.columns.elm_type}</td>
					<td>{phrases.settings.columns.list_values}</td>
					<td>{phrases.settings.columns.multilng}</td>
				</tr>
				
				<loop name="table_fields">
				<tr class="tblcontent" id="row{table_fields.id}" onmouseover="javascript: change_row_color(overRowColor,{table_fields.id});" onmouseout="javascript: change_row_color(outRowColor,{table_fields.id});">
					<td>{table_fields.title}</td>
					<td>{table_fields.column_name}</td>
					<td>{table_fields.description}</td>
					<td>{table_fields.column_type}</td>
					<td>{table_fields.elm_type}</td>
					<td><block name="table_fields.is_list_values"><a style="cursor:pointer;" onclick="javascript: openCenteredWindow('main.php?content=catalog&page=list&filters=1&module={table_fields.list_values_module}&id={table_fields.list_values_parent_id}&filter_category_id={table_fields.list_values_parent_id}&parent_module={module.id}&parent_column={table_fields.column_name}', 'list', 750, 550);">{phrases.settings.list_values_link}</a></block name="table_fields.is_list_values"></td>
					<td>{table_fields.multilng}</td>
				</tr>
				</loop name="table_fields">
				
			</table>
			
		</td>
	</tr>
	<tr>
		<td colspan="3">
		
		<a href="main.php?content={get.content}&module={module.table_name}&page=export&empty=1"><img src="images/export.gif" border="0" alt="" style="vertical-align:middle;" /> {phrases.catalog.generate_csv_template}</a>
		&nbsp;&nbsp;&nbsp;
		<a href="main.php?content={get.content}&module={module.table_name}&page=pdfmanual" target="_blank"><img src="images/pdf.gif" border="0" alt="" style="vertical-align:middle;" /> {phrases.catalog.generate_pdf_module_manual}</a>
		
		</td>
	</tr>
</table>