<div class="crm-project-id-{$vid} crm-block crm-volunteer-signup-form-block">
  {include file="CRM/UF/Form/Block.tpl" fields=$volunteerProfile}

  <div class="crm-section volunteer_role-section">
    <div class="label">{$form.volunteer_role.label}</div>
    <div class="content">{$form.volunteer_role.html}</div>
  </div>
  <div class="crm-section volunteer_shift-section">
    <div class="label">{$form.volunteer_need.label}</div>
    <div class="content">{$form.volunteer_need.html}</div>
  </div>
  <div class="crm-section volunteer_details-section">
    <div class="label">{$form.details.label}</div>
    <div class="content">{$form.details.html}</div>
  </div>

  <div>
    {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
</div>