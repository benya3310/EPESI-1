{if $no_comments}
	{$no_comments}<br>
{else}
	{foreach item=c from=$comments}
	<table border=0 id="comment" cellpadding=0 cellspacing=0>
	<tr>
		<td rowspan=2 width={$c.tabs*40} />
		<td rowspan=2 class="user">{$c.user}</td>
		<td class="date">{$c.date}</td>
		<td class="action">{$c.reply}&nbsp;{$c.delete}&nbsp;{$c.report}</td>
	</tr>
	<tr>
		<td class="contents" colspan=4 width={$c.tabs*-40+400}>{$c.text}</td>
	</tr>
	</table>
	{/foreach}
	<table><tr align=right><td width=245>
		{$first}&nbsp;{$prev}
	</td>
	<td width=55>
		{$next}&nbsp;{$last}
	</td><td width=190>
		{foreach item=text from=$pages}{$text}&nbsp;{/foreach}
	</td></tr></table>
{/if}

{if $form_name}
	{$form_data.javascript}
	<form {$form_data.attributes}> 
		{$form_data.hidden}
		{$form_data.header.reply}<br>
		{if $form_data.whole.html}
			{$form_data.whole.html}<br>
		{/if}
		{$form_data.comment_page_reply.label}{$form_data.comment_page_reply.html}<br>
		{$form_data.submit_comment.html}
	</form>
{else}
	{if $reply_button}
		{$reply_button}
	{/if}
{/if}
