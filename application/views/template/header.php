

<div id="header" class="head">
	<div class="logo-text">E-Trucking</div>
	
    <div id="right-stats-bar">
<!-- ACCOUNT STATS STARTS HERE -->
	<?php $this->m_core->table = T_TRANSACTION; 
		  $this->m_core->data_only = TRUE;
		  $this->m_core->use_join = FALSE;
		  $this->m_core->use_pagination = FALSE;
		  $this->m_core->filters = "";
		  $receivables = 0;
		  $payables = 0;
	?>
	<ul class="horizontal-menu">
		<?php if(validateUserAccess("account","receivables")) { ?>
			<?php 
				if($this->m_core->listing(" sum(transaction_amount) AS transaction_amount ", array("transaction_mode"=>TRANSACTION_MODE_RECEIVABLE,"transaction_type"=>TRANSACTION_TYPE_ENTRY))) {
					$receivables += $this->m_core->class_data["transaction_amount"];
				  }
				  if($this->m_core->listing(" sum(transaction_amount) AS transaction_amount ", array("transaction_mode"=>TRANSACTION_MODE_RECEIVABLE,"transaction_type"=>TRANSACTION_TYPE_CREDIT))) {
					$receivables -= $this->m_core->class_data["transaction_amount"];
				  }
			?>
			<li class="stats">
				<a href="<?php echo base_url("account/receivables"); ?>">
					<span class="stat-small">Receivable</span>
					<span class="stat-big"><?php echo currency_format($receivables, TRUE); ?></span>
				</a>
			</li>
		<?php } ?>

		<?php if(validateUserAccess("account","payables")) { ?>
			<?php 
				 if($this->m_core->listing(" sum(transaction_amount) AS transaction_amount ", array("transaction_mode"=>TRANSACTION_MODE_PAYABLE,"transaction_type"=>TRANSACTION_TYPE_ENTRY))) {
					$payables += $this->m_core->class_data["transaction_amount"];
				  }
				  if($this->m_core->listing(" sum(transaction_amount) AS transaction_amount ", array("transaction_mode"=>TRANSACTION_MODE_PAYABLE,"transaction_type"=>TRANSACTION_TYPE_DEBIT))) {
					$payables -= $this->m_core->class_data["transaction_amount"];
				  }
			?>
			<li class="stats">
				<a href="<?php echo base_url("account/payables"); ?>">
					<span class="stat-small">Payable</span>
					<span class="stat-big"><?php echo currency_format($payables, TRUE); ?></span>
				</a>
			</li>
			<li class="user">
				<?php $oUser = getLoggedUser(); ?>
                <div id="profile-box">
                    <h4><?php echo $oUser->user_name; ?></h4>
                    <p align="right"><a href="<?php echo base_url().'user/change_password'; ?>" title="Change Password"><i class="fa fa-key fa-2x"></i></a>&nbsp;&nbsp;
                    <a href="<?php echo base_url().'logout'; ?>" title="Log Out"><i class="fa fa-sign-out fa-2x"></i></a></p>
                </div>
			</li>
		<?php } ?>
	</ul>
    </div>
<!-- ACCOUNT STATS ENDS HERE -->
</div>