<?

function begin_breadcrumb()
{
  if(p('__chromeless')) return;
  global $breadcrumbs, $breadcrumb_buttons;
  $id = "id_".uniqid();
  $breadcrumbs[$id] = array();
  $breadcrumb_buttons[$id]=array();
  return "<span id='$id'></span>";
}


function end_breadcrumb()
{
  if(p('__chromeless')) return;
  global $breadcrumbs, $breadcrumb_buttons;
  $keys = array_keys($breadcrumbs);
  $id = $keys[count($keys)-1];
  $bc_arr = array_pop($breadcrumbs);
  $bt_arr = array_pop($breadcrumb_buttons);
  if(!$bc_arr && !$bt_arr) return '';
  
  $crumbs = array();
  $c=1;
  foreach($bc_arr as $label=>$url)
  {
    if($url && $c<count($bc_arr))
    {
      $crumbs[] = link_to(h($label), $url);
    } else {
      $crumbs[] = h($label);
    }
    $c++;
  }
  
  
  $buttons = array();
  foreach($bt_arr as $label=>$url)
  {
    $buttons[] = "<div class='button clickable'>".link_to(h($label), $url)."</div>";
  }

  $crumbs = join(' > ', $crumbs);
  $buttons = join(' ', $buttons);
    
  $div = j("<div class=\"breadcrumb\"><div class='crumbs'>$crumbs</div><div class='buttons'>$buttons<div class='clear'></div></div><div class='clear'></div></div>");
  return <<<BC
<script type="text/javascript">
  //<![CDATA[
  \$(function() {
    \$('#$id').append('$div');
  });
  //]]>
</script>
BC;
}

function add_breadcrumb($name, $url)
{
  if(p('__chromeless')) return;
  global $breadcrumbs;
  $keys = array_keys($breadcrumbs);
  if(count($keys)==0) click_error("Must use begin_breadcrumb() before add_breadcrumb().");
  $id = $keys[count($keys)-1];
  $breadcrumbs[$id][$name] = $url;
}

function add_breadcrumb_button($label, $url)
{
  if(p('__chromeless')) return;
  global $breadcrumb_buttons;
  $keys = array_keys($breadcrumb_buttons);
  if(count($keys)==0) click_error("Must use begin_breadcrumb() before add_breadcrumb_button().");
  $id = $keys[count($keys)-1];
  $breadcrumb_buttons[$id][$label] = $url;
}