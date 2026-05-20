

<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="index.html" class="logo logo-light">
        <span class="logo-lg">
            <img src="<?php echo e(asset('probox/public/assets/images/logo.png')); ?>" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="<?php echo e(asset('probox/public/assets/images/logo-sm.png')); ?>" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="index.html" class="logo logo-dark">
        <span class="logo-lg">
            <img src="<?php echo e(asset('probox/public/assets/images/logo-dark.png')); ?>" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="<?php echo e(asset('probox/public/assets/images/logo-dark-sm.png')); ?>" alt="small logo">
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="pages-profile.html">
                <img src="<?php echo e(asset('assets/images/prologo.jpg')); ?>" alt="user-image"
                    height="42" class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">ProBox</span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Navigation</li>

            <li class="side-nav-item">
               <a href="<?php echo e(route('dashboard.admin')); ?>" class="side-nav-link">
             <i class="uil-calender"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-title">Apps</li>


            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarLayouts" aria-expanded="false" aria-controls="sidebarLayouts"
                    class="side-nav-link">
                    <i class="uil-wallet"></i>
                    <span> Accounts</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarLayouts">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo e(route('level1.list')); ?>">Level1</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('level2.list')); ?>">Level2</a>
                        </li>
                        <li>
                        <li>
                            <a href="<?php echo e(route('amaster.list')); ?>">Chart Of Account</a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('cash.reports')); ?>">Cash Receipt</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('cheque_receipts.reports')); ?>">Cheque Receipts</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('payment.reports')); ?>">Cash Payment</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('bank_recipt.reports')); ?>">Bank Receipt</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('bank_payment.reports')); ?>">Bank Payment</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('ledger.list')); ?>">Ledger</a>
                        </li>
                         <li>
                            <a href="<?php echo e(route('office_cash.reports')); ?>">Office Cash</a>
                        </li>
                         
                        

                        <li>
                            <a href="<?php echo e(route('payables.list')); ?>">Payables</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('recieveables.list')); ?>">Recieveable</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('journal_voucher.reports')); ?>">Journal Voucher</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('open_bal.reports')); ?>">Opening Balance</a>
                        </li>
                    </ul>
                </div>
            </li>
            
            
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmails2" aria-expanded="false" aria-controls="sidebarEmails2"
                    class="side-nav-link">
                    <i class="uil-chart-line"></i>
                    <span> Reports </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEmails2">
                    <ul class="side-nav-second-level">
                         <li>
                            <a href="<?php echo e(route('bank_cash.reports')); ?>">Bank/Cash Receipt Report</a>
                        </li>
                        
                        <li>
                            <a href="<?php echo e(route('expense.reports')); ?>">Expense Report</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('purchase.reports')); ?>">Purchase Reports</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('sale.reports')); ?>">Sale Reports</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('daily_statement.reports')); ?>">Daily Statement</a>
                        </li>
                        
                        <!--<li>-->
                        <!--    <a href="<?php echo e(route('stock_report.reports')); ?>">Stock Reports</a>-->
                        <!--</li>-->
                        <li>
                            <a href="<?php echo e(route('report.stock')); ?>">Stock Reports</a>
                        </li>
                         <li>
                            <a href="<?php echo e(route('stock_report')); ?>">Boxboard Stock Reports</a>
                        </li>

                    </ul>
                </div>
            </li>
            
            

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmails" aria-expanded="false" aria-controls="sidebarEmails"
                    class="side-nav-link">
                    <i class="uil-receipt"></i>
                    <span> Billing </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEmails">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo e(route('pharma_billing.reports')); ?>">Pharmaceutical Billing</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('confect_billing.reports')); ?>">Confectionery Billing</a>
                        </li>
                        
                       <li>
                            <a href="<?php echo e(route('general_billing.report')); ?>">General Billing</a>
                        </li>

                    </ul>
                </div>
            </li>
            
             <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmails26" aria-expanded="false" aria-controls="sidebarEmails26"
                    class="side-nav-link">
                    <i class="uil-money-bill"></i>
                    <span> Wage Calculator </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEmails26">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo e(route('boxboard_wage.report')); ?>">Boxboard Cutting Dept</a>
                        </li>
                       

                    </ul>
                </div>
            </li>
            
            
             <li class="side-nav-item">
                <a href="<?php echo e(route('salary_calc.list')); ?>" class="side-nav-link">
                    <i class="uil-money-withdrawal"></i>
                    <span> Salary Calculator </span>
                </a>
            </li>
            
    

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmao1" aria-expanded="false" aria-controls="sidebarEmao1"
                    class="side-nav-link">
                    <i class="uil-envelope"></i>
                    <span>Delivery Challan</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEmao1">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo e(route('delivery_challan.reports')); ?>">Pharmaceutical</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('confectionery.reports')); ?>">Confectionery</a>
                        </li>
                         <li>
                            <a href="<?php echo e(route('general_delivery_challan.report')); ?>">General</a>
                        </li>
                    </ul>
                </div>
            </li>


<li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmao14" aria-expanded="false" aria-controls="sidebarEmao14"
                    class="side-nav-link">
                    <i class="uil-trash-alt"></i>
                    <span>Wastage Sale</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEmao14">
                    <ul class="side-nav-second-level">
                
            
            
            
             <li>
                            <a href="<?php echo e(route('wastage_sale.reports')); ?>">Wastage Sale</a>
                        </li>

 <li>
                            <a href="<?php echo e(route('wastage.reports')); ?>">Wastage Sale Reports</a>
                        </li>
                        
                    </ul>
                </div>
            </li>
            
            <li class="side-nav-item">
                <a href="<?php echo e(route('gate_ex.reports')); ?>" class="side-nav-link">
                    <i class="uil-exit"></i>
                    <span> Gate Ex </span>
                </a>
            </li>
            
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarRegistrationForm1" aria-expanded="false"
                    aria-controls="sidebarRegistrationForm1" class="side-nav-link">
                    <i class="uil-envelope"></i>
                    <span>Gate Pass</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarRegistrationForm1">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo e(route('gate_pass_in.reports')); ?>">Gate-Pass In</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('gate_pass_out.reports')); ?>">Gate-Pass Out</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmai" aria-expanded="false" aria-controls="sidebarEmai"
                    class="side-nav-link">
                    <i class="uil-envelope"></i>
                    <span> Purchase</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEmai">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo e(route('payment_invoice.reports')); ?>">Boxboard Purchase</a>
                        </li>
                      
                        <li>
                            <a href="<?php echo e(route('plate_purchase.reports')); ?>">Plate Purchase</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('glue_purchase.reports')); ?>">Glue Purchase</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('ink_purchase.reports')); ?>">Ink Purchase</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('lemination_purchase.reports')); ?>">Lamination Purchase</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('corrugation_purchase.reports')); ?>">Corrugation Purchase</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('shipper_purchases.reports')); ?>">Shipper Purchase</a>
                        </li>
                         <li>
                            <a href="<?php echo e(route('dye_purchases.reports')); ?>">Dye Purchase</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('disposable_purchase.reports')); ?>">Disposable Purchase</a>
                        </li>
                        
                    </ul>
                </div>
            </li>
            
            
            
            
            
            
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmai333" aria-expanded="false" aria-controls="sidebarEmai333"
                    class="side-nav-link">
                    <i class="uil-envelope"></i>
                    <span>Purchase Return</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEmai333">
                    <ul class="side-nav-second-level">
                         <li>
                            <a href="<?php echo e(route('purchase_return.reports')); ?>">Boxboard Return</a>
                        </li>
                      
                        <li>
                            <a href="<?php echo e(route('plate_return.reports')); ?>">Plate Return</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('glue_return.reports')); ?>">Glue Return</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('ink_return.reports')); ?>">Ink Return</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('lamination_return.reports')); ?>">Lamination Return</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('corrugation_return.reports')); ?>">Corrugation Return</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('shipper_return.reports')); ?>">Shipper Return</a>
                        </li>
                         <li>
                            <a href="<?php echo e(route('dye_return.reports')); ?>">Dye Return</a>
                        </li>
                         
                    </ul>
                </div>
            </li>
            
            
            
            
            

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmail" aria-expanded="false" aria-controls="sidebarEmail"
                    class="side-nav-link">
                    <i class="uil-box"></i>
                    <span> Inventory </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEmail">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo e(route('inventory.itemtype.list')); ?>">Item Type</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('inventory.itemmaster.list')); ?>">Item Registration</a>
                        </li>
                          <li>
    <a href="<?php echo e(route('stock-adj.index')); ?>">Stock Adjustment</a>
</li>


                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="<?php echo e(route('registration_form.reports')); ?>" class="side-nav-link">
                    <i class="uil-clipboard-notes"></i>
                    <span> Product Registration </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<?php echo e(route('packaging-specs.index')); ?>" class="side-nav-link">
                    <i class="uil-box"></i>
                    <span> Job Details </span>
                </a>
            </li>

            
            
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarRegistrationFormj" aria-expanded="false"
                    aria-controls="sidebarRegistrationFormj" class="side-nav-link">
                    <i class="uil-file-alt"></i>
                    <span>Job Sheet</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarRegistrationFormj">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo e(route('job.report')); ?>">Job Sheet</a>
                        </li>
                        
                        <li>
                            <a href="<?php echo e(route('general_job_sheet.report')); ?>">General Job Sheet</a>
                        </li>
                       
                    </ul>
                </div>
            </li>
            
            
             <li class="side-nav-item">
                <a href="<?php echo e(route('attendence_form.reports')); ?>" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span>Attendance System</span>
                </a>
            </li>
            
            
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarRegistrationForm" aria-expanded="false"
                    aria-controls="sidebarRegistrationForm" class="side-nav-link">
                    <i class="uil-schedule""></i>
                    <span>Set-up</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarRegistrationForm">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?php echo e(route('country.index')); ?>">Country Registration</a>
                        </li>
                        
                        <li>
                            <a href="<?php echo e(route('erp_param.list')); ?>">ERP Parameters</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('product_log.report')); ?>">Product Log</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('inventory.item_log')); ?>">Item Registration Log</a>
                        </li>
                    </ul>
                </div>
            </li>

<li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarRegistrationForm2" aria-expanded="false"
                    aria-controls="sidebarRegistrationForm2" class="side-nav-link">
                    <i class="uil-building""></i>
                    <span>Set-Up Department</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarRegistrationForm2">
                    <ul class="side-nav-second-level">
                      
                        <li>
                            <a href="<?php echo e(route('print.index')); ?>">Department</a>
                        </li>
                        
                         <li>
                            <a href="<?php echo e(route('process.index')); ?>">Level2</a>
                        </li>
                        
                    </ul>
                </div>
            </li>
            
            
            
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarRegistrationForm236" aria-expanded="false"
                    aria-controls="sidebarRegistrationForm236" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span>Employee</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarRegistrationForm236">
                    <ul class="side-nav-second-level">
                      
                        <li>
                            <a href="<?php echo e(route('employees.reports')); ?>">Add Employee</a>
                        </li>
                        
                         <li>
                            <a href="<?php echo e(route('employee_type.reports')); ?>">Register Employee in New Department</a>
                        </li>
                        
                         <li>
                            <a href="<?php echo e(route('designation.index')); ?>">Add Designation</a>
                        </li>
                        
                        <li>
                            <a href="<?php echo e(route('extra_time.index')); ?>">Add Bonus Type</a>
                        </li>
                        
                        
                    </ul>
                </div>
            </li>
            
            
            
            <li class="side-nav-item">
                <a href="<?php echo e(route('create_account.reports')); ?>" class="side-nav-link">
                    <i class="uil-user"></i>
                    <span> User settings </span>
                </a>
            </li>
            
            
         


          
            <li class="side-nav-item">
                <a href="<?php echo e(route('category.list')); ?>" class="side-nav-link">
                    <i class="uil-apps"></i>
                    <span> Category </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<?php echo e(route('admin.backup')); ?>" class="side-nav-link">
                    <i class="uil-cloud-upload"></i>
                    <span> Backup </span>
                </a>
            </li>

            <!-- Help Box -->
            <!--<div class="help-box text-white text-center">-->
            <!--    <a href="javascript: void(0);" class="float-end close-btn text-white">-->
            <!--        <i class="mdi mdi-close"></i>-->
            <!--    </a>-->
            <!--    <img src="<?php echo e(asset('probox/public/assets/images/svg/help-icon.svg')); ?>" height="90"-->
            <!--        alt="Helper Icon Image" />-->
            <!--    <h5 class="mt-3">Unlimited Access</h5>-->
            <!--    <p class="mb-3">Upgrade to plan to get access to unlimited reports</p>-->
            <!--    <a href="javascript: void(0);" class="btn btn-secondary btn-sm">Upgrade</a>-->
            <!--</div>-->
            <!-- end Help Box -->


        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div><?php /**PATH C:\laragon\www\probox\resources\views/components/sidebar.blade.php ENDPATH**/ ?>