<h2> {$LANG.sinusdocker_musicbot} SinusBot</h2>

<p>SinusBot - {$LANG.sinusdocker_musicbot_description}</p>

<div class="alert alert-info">
    {$LANG.sinusdocker_for_setting_data} 
</div>

<h3>{$LANG.clientareaproductdetails}</h3>

<hr>

{if $dedicatedip}
    <div class="row">
        <div class="col-sm-5">
            {$LANG.domainregisternsip}
        </div>
        <div class="col-sm-7">
            {$dedicatedip}
        </div>
    </div>
{/if}

{foreach from=$configurableoptions item=configoption}
    <div class="row">
        <div class="col-sm-5">
            {$configoption.optionname}
        </div>
        <div class="col-sm-7">
            {if $configoption.optiontype eq 3}
                {if $configoption.selectedqty}
                    {$LANG.yes}
                {else}
                    {$LANG.no}
                {/if}
            {elseif $configoption.optiontype eq 4}
                {$configoption.selectedqty} x {$configoption.selectedoption}
            {else}
                {$configoption.selectedoption}
            {/if}
        </div>
    </div>
{/foreach}



<div class="row">
    <div class="col-sm-5">
        {$LANG.orderpaymentmethod}
    </div>
    <div class="col-sm-7">
        {$paymentmethod}
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        {$LANG.firstpaymentamount}
    </div>
    <div class="col-sm-7">
        {$firstpaymentamount}
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        {$LANG.recurringamount}
    </div>
    <div class="col-sm-7">
        {$recurringamount}
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        {$LANG.clientareahostingnextduedate}
    </div>
    <div class="col-sm-7">
        {$nextduedate}
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        {$LANG.orderbillingcycle}
    </div>
    <div class="col-sm-7">
        {$billingcycle}
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        {$LANG.clientareastatus}
    </div>
    <div class="col-sm-7">
        <span class="label status status-{$rawstatus|strtolower}" style="width: 90px;">{$status}</span>
    </div>
</div>

{if $status eq {$LANG.clientareaactive}} 
    <hr>
    <h3>{$LANG.sinusdocker_data_for_a_control_panel}</h3>
    <hr>
    <div class="row">
        <div class="col-sm-5">
            {$LANG.sinusdocker_link_control_panel}
        </div>
        <div class="col-sm-7">
            <a href="{$domain}"> {$domain}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            {$LANG.sinusdocker_login}
        </div>
        <div class="col-sm-7">
            {$username}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-5">
            {$LANG.sinusdocker_passwd}
        </div>
        <div class="col-sm-7">
            {$password}
        </div>
    </div> 

    <br><br>
    <hr>
    <h3>{$LANG.sinusdocker_log_bot}</h3>
    <hr>

    <textarea style="display: block;margin: 0 auto;font-size: 11px;" rows="10" cols="140" name="text" disabled> {$logs}</textarea>
{/if}

{if $status eq {$LANG.clientareaterminated}} 
    <br><br>
    <span style="padding:2px 10px;background-color:#cc0000;color:#fff;text-align: center;display: block;margin: 0 auto;width: 149px;height: 100%;">
        <strong>{$LANG.sinusdocker_service_deleted}</strong>
    </span> 
{/if}

{if $status eq {$LANG.clientareasuspended}} 
    <br><br>
    <span style="padding:2px 10px;background-color:#cc0000;color:#fff;text-align: center;display: block;margin: 0 auto;width: 400px;height: 100%;">
        <strong>{$LANG.sinusdocker_service_suspended}</strong><br/>
        <strong>   {$LANG.suspendreason}: {$suspendreason}</strong>
    </span> 
{/if}