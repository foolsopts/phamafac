<ol class="breadcrumb">
    <li><a href="{$BASEURL}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
    {foreach $module_data[$module_name]["visible"]["name"] as $key => $b}
    <li {if $b === $module_data[$module_name]["active"]}class="active" {/if}>
        {if $b !== $module_data[$module_name]["active"]}
        <a href="{$BASEURL}{$module_data[$module_name]["visible"]["url"][$key]}{$b}.html">{$b}</a> {else} {$b} {/if}
    </li>
    {/foreach}
</ol>
