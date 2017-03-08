<nav class="navbar navbar-static-top" role="navigation">
  <div class="navbar-header">
    <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
            <i class="fa fa-reorder"></i>
        </button>
    <a class="hide" href="#" style="float: left;"><img src="{$smarty.const.ROOTURL}core_themes/img/logo.png" style="width: 120px;"></a>
    <a href="{if !empty($smarty.session.id)}{$BASEURL}{else}{$smarty.const.ROOTURL}{/if}" class="navbar-brand" style="text-shadow: 0px 0px 4px black;">PCG</a>
  </div>
  <div class="navbar-collapse collapse" id="navbar">
    <ul class="nav navbar-nav">
      <li class="active">
        <a aria-expanded="false" role="button" href="#"> สำหรับผู้บริหาร</a>
      </li>
      {foreach $content as $val}
      <!--/////////////////////////////////-->
        <li class="dropdown">
          <a aria-expanded="false" role="button" href="{$val.url}" {if $val.url === "#"}class="dropdown-toggle" data-toggle="dropdown"{/if}>{$val.name}{if $val.child|@count gt 0}<span class="caret"></span>{/if}</a>
          {if $val.child|@count gt 0}
          <ul role="menu" class="dropdown-menu">
          {foreach $val.child as $cc}
            <li><a href="{$cc.url}">{$cc.name}</a></li>
          {/foreach}
          </ul>
          {/if}
        </li>
      <!--/////////////////////////////////-->
      {/foreach}
    </ul>
    {if !empty($smarty.session.id)}
    <ul class="nav pull-right">
      <li>
        <a href="{$BASEURL}logout.html">
          <i class="fa fa-sign-out"></i> Log out
        </a>
      </li>
    </ul>
    {/if}
  </div>
</nav>
