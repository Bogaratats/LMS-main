   <?php

   include 'components/connect.php';

   $userCount = 0;
   $tutorCount = 0;

   if (isset($_COOKIE['user_id'])) {
      $user_id = $_COOKIE['user_id'];
   } else {
      $user_id = '';
   }

   try {
      // Query to get count of users
      $userCountQuery = "SELECT COUNT(*) AS userCount FROM users";
      $userResult = $conn->query($userCountQuery);
      if ($userResult) {
         $userData = $userResult->fetch(PDO::FETCH_ASSOC);
         if ($userData) {
            $userCount = $userData['userCount'];
         } else {
            echo "No user data found.";
         }
      } else {
         echo "User count query failed.";
      }

      // Query to get count of tutors
      $tutorCountQuery = "SELECT COUNT(*) AS tutorCount FROM tutors";
      $tutorResult = $conn->query($tutorCountQuery);
      if ($tutorResult) {
         $tutorData = $tutorResult->fetch(PDO::FETCH_ASSOC);
         if ($tutorData) {
            $tutorCount = $tutorData['tutorCount'];
         } else {
            echo "No tutor data found.";
         }
      } else {
         echo "Tutor count query failed.";
      }

      $courseCountQuery = "SELECT COUNT(*) AS courseCount FROM `playlist` WHERE status = 'active'";
      $courseResult = $conn->query($courseCountQuery);
      if ($courseResult) {
         $courseData = $courseResult->fetch(PDO::FETCH_ASSOC);
         if ($courseData) {
            $courseCount = $courseData['courseCount'];
         } else {
            echo "No course data found.";
         }
      } else {
         echo "Course count query failed.";
      }
   } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
   }

   if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
      // Get the form data
      $comment = $_POST['comment'];
      $rating = $_POST['rating'];

      // Insert the review into the database
      try {
         // Assuming you have a 'comments' table with appropriate columns
         $insert_review = $conn->prepare("INSERT INTO comments (user_id, comment, rating, date) VALUES (?, ?, ?, NOW())");
         // Assuming $user_id is set elsewhere in your code
         $insert_review->execute([$user_id, $comment, $rating]);
         // Redirect to the same page after successful submission to avoid form resubmission
         header("Location: about.php");
         exit(); // Make sure to exit after redirection
      } catch (PDOException $e) {
         // Handle database insertion error
         echo "Error: " . $e->getMessage();
      }
   }

   // Fetch comments along with user information
   try {
      $select_comments = $conn->prepare("SELECT comments.*, users.name AS user_name, users.image FROM comments INNER JOIN users ON comments.user_id = users.id");
      $select_comments->execute();
      $reviews = $select_comments->fetchAll(PDO::FETCH_ASSOC);
   } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
   }


   // Fetch comments along with user information
   try {
      $select_comments = $conn->prepare("SELECT comments.*, users.name AS user_name, users.image FROM comments INNER JOIN users ON comments.user_id = users.id");
      $select_comments->execute();
      $reviews = $select_comments->fetchAll(PDO::FETCH_ASSOC);
   } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
   }


   ?>

   <!DOCTYPE html>
   <html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>about</title>

      <!-- font awesome cdn link  -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

      <!-- custom css file link  -->
      <link rel="stylesheet" href="css/style.css">

   </head>

   <body>

      <?php include 'components/user_header.php'; ?>

      <!-- about section starts  -->

      <section class="about">

         <div class="row">

            <div class="image">
               <img src="images/about-img.svg" alt="">
            </div>

            <div class="content">
               <h3>Why choose us?</h3>
               <p>LearnHub streamlines educational processes, offering centralized access to courses, materials, and assessments. It enhances collaboration, facilitates personalized learning, and enables easy tracking of student progress. With features like multimedia support and analytics, an LMS optimizes teaching efficiency and fosters a dynamic learning environment.</p>

               <a href="courses.php" class="inline-btn">our courses</a>
            </div>

         </div>

         <div class="box-container">

            <div class="box">
               <i class="fas fa-graduation-cap"></i>
               <div>
                  <h3><?php echo $courseCount; ?></h3>
                  <span>Online courses</span>
               </div>
            </div>

            <div class="box">
               <i class="fas fa-user-graduate"></i>
               <div>
                  <h3><?php echo $userCount; ?></h3>
                  <span>Brilliants Students</span>
               </div>
            </div>

            <div class="box">
               <i class="fas fa-chalkboard-user"></i>
               <div>
                  <h3><?php echo $tutorCount; ?></h3>
                  <span>Expert Teachers</span>
               </div>
            </div>

            <div class="box">
               <i class="fas fa-briefcase"></i>
               <div>
                  <h3>100%</h3>
                  <span>Job Placement</span>
               </div>
            </div>

         </div>

      </section>

      <!-- about section ends -->

      <!-- reviews section starts  -->

      <section class="reviews">

         <h1 class="heading">Student's Reviews</h1>

         <div class="box-container">

            <div class="box">
               <p>Great platform for learning new skills. The courses are well-structured and easy to follow.</p>
               <div class="user">
                  <img src="images/pic-3.jpg" alt="">
                  <div>
                     <h3>Martinez, Mark Joseph M.</h3>
                     <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                     </div>
                  </div>
               </div>
            </div>

            <div class="box">
               <p>Excellent selection of courses. The instructors are knowledgeable and engaging.</p>
               <div class="user">
                  <img src="images/pic-3.jpg" alt="">
                  <div>
                     <h3>Ruiz Miguel Sapio</h3>
                     <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                     </div>
                  </div>
               </div>
            </div>

            <div class="box">
               <p>This platform helped me enhance my skills and advance in my career.</p>
               <div class="user">
                  <img src="images/pic-2.jpg" alt="">
                  <div>
                     <h3>Lea Rose Revadenera</h3>
                     <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                     </div>
                  </div>
               </div>
            </div>

            <div class="box">
               <p>The content is comprehensive and the instructors are responsive to questions.</p>
               <div class="user">
                  <img src="images/pic-5.jpg" alt="">
                  <div>
                     <h3>Kimberly Caguite</h3>
                     <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                     </div>
                  </div>
               </div>
            </div>

            <div class="box">
               <p>I highly recommend this platform to anyone looking to expand their knowledge.</p>
               <div class="user">
                  <img src="images/pic-7.jpg" alt="">
                  <div>
                     <h3>Raven Araño</h3>
                     <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                     </div>
                  </div>
               </div>
            </div>

            <div class="box">
               <p>The platform offers a wide range of courses suitable for learners of all levels.</p>
               <div class="user">
                  <img src="images/pic-6.jpg" alt="">
                  <div>
                     <h3>Herald Hillary Beter</h3>
                     <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                     </div>
                  </div>
               </div>
            </div>

            <div class="box">
               <p>The platform has helped me acquire valuable skills that are directly applicable to my job. I'm grateful for the comprehensive content and expert instructors.</p>
               <div class="user">
                  <img src="images/pic-4.jpg" alt="">
                  <div>
                     <h3>John Simon Arcillas</h3>
                     <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                     </div>
                  </div>
               </div>
            </div>

            <?php if (!empty($reviews)) : ?>
               <?php foreach ($reviews as $review) : ?>
                  <div class="box">
                     <p><?php echo $review['comment']; ?></p>
                     <div class="user">
                        <img src="<?php echo './images/pic-2.jpg' . $user['image']; ?>" alt="<?php echo $user['name']; ?>'s profile picture">
                        <div>
                           <h3><?php echo $review['user_name']; ?></h3>
                           <!-- Display star icons based on the rating -->
                           <div class="stars">
                              <?php
                              // Calculate the number of full stars
                              $fullStars = floor($review['rating']);
                              // Calculate the number of empty stars
                              $emptyStars = 5 - $fullStars;

                              // Full stars
                              for ($i = 0; $i < $fullStars; $i++) : ?>
                                 <i class="fas fa-star"></i>
                              <?php endfor;

                              // Half star, if applicable
                              if ($review['rating'] % 1 !== 0) : ?>
                                 <i class="fas fa-star-half-alt"></i>
                              <?php $emptyStars--; // Reduce empty stars count by 1 if there's a half star
                              endif;

                              // Empty stars
                              for ($i = 0; $i < $emptyStars; $i++) : ?>
                                 <i class="far fa-star"></i>
                              <?php endfor;
                              ?>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php endforeach; ?>
            <?php else : ?>
               <p>No reviews available.</p>
            <?php endif; ?>

         </div>

         <br><br>
         <h1 class="heading">Add a Review</h1>

      </section>


      <form class="f1" action="about.php" method="post">
         <textarea class="ta" name="comment" placeholder="Enter your review"></textarea>
         <select class="sl" name="rating">
            <option value="1">1 Star</option>
            <option value="2">2 Stars</option>
            <option value="3">3 Stars</option>
            <option value="4">4 Stars</option>
            <option value="5">5 Stars</option>
         </select>
         <input type="submit" name="submit" value="Submit review" class="btn">
      </form>

      <!-- reviews section ends -->










      <?php include 'components/footer.php'; ?>

      <!-- custom js file link  -->
      <script src="js/script.js"></script>

   </body>

   </html>