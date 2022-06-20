<header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">


<div class="m-header">
    <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
    <a href="#!" class="b-brand">
        <h5 class="" style="color: white;">Era Digital Media </h5>

    </a>
    <a href="#!" class="mob-toggler">
        <i class="feather icon-more-vertical"></i>
    </a>
</div>
<div class="collapse navbar-collapse">
   
    <ul class="navbar-nav ml-auto">
        <li>
            <a href="<?= base_url();?>" target="_new" class="dropdown">
                <i class="feather icon-airplay"></i>
            </a>
        </li>
        <li>
            <div class="dropdown drp-user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="feather icon-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-notification">
                    <div class="pro-head">
                        <span><?php echo $this->session->userdata('fullName'); ?> </span>
                        <a href="<?= base_url();?>dashboard/logout" class="dud-logout" title="Logout">
                            <i class="feather icon-log-out"></i>
                        </a>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>


</header>