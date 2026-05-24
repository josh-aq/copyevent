-- Migration: create post_comments table
-- Run this with the provided migrate.php script or manually via MySQL client

CREATE TABLE IF NOT EXISTS post_comments (
  comment_id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  user_id INT NOT NULL,
  comment TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (post_id),
  INDEX (user_id),
  CONSTRAINT fk_post_comments_post FOREIGN KEY (post_id) REFERENCES user_posts(post_id) ON DELETE CASCADE,
  CONSTRAINT fk_post_comments_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
