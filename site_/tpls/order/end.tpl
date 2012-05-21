<h1>{phrases.order_title}</h1>

<div id="path">
<a href="{lng}/">{phrases.products_menu}</a>
&nbsp;&nbsp;»&nbsp;&nbsp;{phrases.order_title}
</div>											

<div id="order_steps">
	
	<call code="name=steps::set=loop::module=orders::method=loadSteps::params=">
	<loop name="steps">
	<div class="step<block name="steps.complited"> c</block name="steps.complited"><block name="steps.active"> a</block name="steps.active">">
		<div class="img png">{steps.num}</div>
		<p>{steps.title}</p>
	</div>
	</loop name="steps">

</div>										


<call code="name=order_text::set=var::module=orders::method=endOrder::params={{get.id}}">
{order_text}