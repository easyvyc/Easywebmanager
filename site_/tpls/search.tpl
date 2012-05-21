<call code="name=item_data::set=var::module=pages::method=loadPage::params={{page_data.id}}">
<div class="box1">
	<div class="border-top">
		<div class="border-right">
			<div class="border-bot">
				<div class="border-left">
					<div class="left-top-corner">
						<div class="right-top-corner">
							<div class="right-bot-corner">
								<div class="left-bot-corner">
									<div class="inner">
										<h1>{phrases.search_title}</h1>

		<block name="short_key">
		{phrases.to_short_key}
		</block name="short_key">
		
		<block name="short_key" no>
		<block name="no_results">
		{phrases.no_search_results}
		</block name="no_results">
		
		<loop name="search_results">
		<loop name="search_results.mod">
		<div class="search_res">
		<block name="search_results.mod.image">
		<a href="{search_results.mod.lng}{search_results.mod.item_url}"><img alt="{search_results.mod.title}" src="{upload_url}thumb_{search_results.mod.image}" /></a>
		</block name="search_results.mod.image">
		<a href="{search_results.mod.lng}{search_results.mod.item_url}">{search_results.mod.title}</a>
		<p>...{search_results.mod._description_}...</p>
		</div>
		</loop name="search_results.mod">
		</loop name="search_results">
		
		
		</block name="short_key" no>


									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>