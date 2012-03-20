<table width="100%">
	<tr>
		{if isset($new_note)}
		<td style="width:110px;">
			<a class="attachment_add_new" {$new_note.href}><img src="{$theme_dir}/Base/ActionBar/icons/add-small.png" />
				<div class="attachment_div_add_new">
					{$new_note.label}
				</div>
			</a>
		</td>
		{/if}
		<td style="width:110px;" id="{$expand_collapse.e_id}">
			<a class="attachment_add_new" {$expand_collapse.e_href}><img src="{$theme_dir}/Base/ActionBar/icons/expand_big.png" />
				<div class="attachment_div_add_new">
					{$expand_collapse.e_label}
				</div>
			</a>
		</td>
		<td style="width:110px;display:none;" id="{$expand_collapse.c_id}">
			<a class="attachment_add_new" {$expand_collapse.c_href}><img src="{$theme_dir}/Base/ActionBar/icons/collapse_big.png" />
				<div class="attachment_div_add_new">
					{$expand_collapse.c_label}
				</div>
			</a>
		</td>
	{if isset($paste)}
		<td style="width:110px;">
			<a class="attachment_add_new" {$paste.href}>
				<div class="attachment_div_add_new">
					{$paste.label}
				</div>
			</a>
		</td>
	{/if}
		<td style="color:#000000">
		
			{$form_open}
			{$form_data.filter_user.label}{$form_data.filter_user.html}&nbsp;&nbsp;{$form_data.filter_start.label}{$form_data.filter_start.html}&nbsp;&nbsp;{$form_data.filter_end.label}{$form_data.filter_end.html}&nbsp;&nbsp;{$form_data.submit_button.label}{$form_data.submit_button.html}<br />
			{$form_close}		
		</td>
	{if isset($show_deleted)}
		<td class="epesi_label">
			{$show_deleted.label}
		</td>
		<td class="epesi_data" style="width:25px;nowrap;">
			<input type="checkbox" {$show_deleted.default} onChange="if(this.checked){$show_deleted.show} else {$show_deleted.hide}" />
		</td>
	{/if}
	</tr>
</table>
