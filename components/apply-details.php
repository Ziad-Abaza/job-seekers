<div class="w-100 p-3 d-flex flex-column justify-content-center align-item-center">
    <div class="my-5">
        <div class="top m-auto">
            <header class="fs-3">Applications</header>
        </div>
        <?php if (!empty($applications)) { ?>
            <div class="border border-3 rounded-5  border-primary w-100 p-2">
                <?php foreach ($applications as $application) : ?>
                    <div class="d-flex gap-3 justify-content-start align-content-center">
                        <div class="d-flex flex-column justify-content-start align-items-start">
                            <p>Name: <?php echo isset($application['name']) ? $application['name'] : ''; ?></p>
                            <p>Email: <?php echo isset($application['email']) ? $application['email'] : ''; ?></p>
                            <p>Type: <?php echo isset($application['type']) ? $application['type'] : ''; ?></p>
                            <p>Education: <?php echo isset($application['education']) ? $application['education'] : ''; ?></p>
                            <p>Specialization: <?php echo isset($application['specialization']) ? $application['specialization'] : ''; ?></p>
                            <p>Location: <?php echo isset($application['location']) ? $application['location'] : ''; ?></p>
                        </div>
                    </div>
                    <div class="d-flex flex-column w-100 gap-2">
                        <?php if (!empty($application['cv'])) { ?>
                            <div class="w-100">
                                <iframe src="<?php echo isset($application['cv']) ? $application['cv'] : ''; ?>" width="100%" height="600px"></iframe>
                            </div>
                        <?php } ?>
                        <div>Download CV:
                            <?php if (!empty($application['cv'])) : ?>
                                <a href="<?php echo $application['cv']; ?>" class="btn btn-primary p-1" download>Download</a>
                            <?php else : ?>
                                <span class="text-muted">CV not available for download</span>
                            <?php endif; ?>
                        </div>
                        <div class="w-75 bg-primary m-auto my-3" style="height:5px; border-radius: 20px"></div>
                    <?php endforeach; ?>
                    </div>
                <?php
            } else {
                echo "<p>Application Not Found .</p>";
            }
                ?>
            </div>
    </div>
</div>