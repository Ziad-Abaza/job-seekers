<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cookies</title>
    <?php require_once 'components/head.php'; ?>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <?php require_once 'components/spinner.php';?>
        <!-- Navbar -->
        <?php require_once 'components/navbar.php';?>

        <!-- Cookies -->
        <div class="container-xxl py-5">
            <div class="container">
                <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Cookies Policy</h1>
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="wow fadeIn" data-wow-delay="0.1s">
                            <p class="wow fadeIn" data-wow-delay="0.2s">This website uses cookies to ensure you get the best experience on our website.</p>
                            <p class="wow fadeIn" data-wow-delay="0.3s">By continuing to use this website, you consent to the use of cookies in accordance with our <a href="">Privacy Policy</a>.</p>
                            <p class="wow fadeIn" data-wow-delay="0.4s">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vel placerat nunc. Nullam nec leo vitae ex fringilla mollis. Integer vitae ullamcorper tortor. In non sem id massa convallis ullamcorper. Suspendisse potenti. Nam id dapibus elit. Maecenas ultrices erat ac tellus interdum, vel fringilla leo lobortis. Nullam nec libero convallis, congue erat eu, viverra lorem. Nam nec elit ac libero volutpat pellentesque. In hac habitasse platea dictumst. Sed non est vel risus tincidunt ultrices.</p>
                            <p class="wow fadeIn" data-wow-delay="0.5s">Phasellus ullamcorper purus in augue maximus mollis. Integer vel consectetur nisi, ac feugiat eros. Nulla facilisi. Aenean vestibulum urna eu nibh venenatis dignissim. Nam interdum pharetra diam vel malesuada. Vestibulum fringilla vel neque nec feugiat. Morbi ornare tellus vitae nunc venenatis, non placerat elit interdum. Vivamus bibendum massa non erat elementum, vitae rhoncus lorem vestibulum.</p>
                            <p class="wow fadeIn" data-wow-delay="0.6s">Sed nec blandit turpis. Nulla ac convallis dolor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris sollicitudin sapien et arcu consequat, et faucibus orci rhoncus. Duis quis metus nec odio fermentum tempus eget vitae justo. Integer sed enim sed ex posuere tristique. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed ut consequat orci.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once 'components/footer.php'; ?>
    </div>
    <?php require_once 'components/scripts.php'; ?>
</body>
</html>
