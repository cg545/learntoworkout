-- TODO: create tables
-- CREATE TABLE `examples` (
-- 	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
-- 	`name`	TEXT NOT NULL
-- );
-- TODO: initial seed data
-- INSERT INTO `examples` (name) VALUES ('example-1');
-- INSERT INTO `examples` (name) VALUES ('example-2');
CREATE TABLE exercises (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL,
  description TEXT NOT NULL,
  submitted_by TEXT NOT NULL,
  date_submitted TEXT NOT NULL,
  approved INTEGER NOT NULL,
  file_name TEXT NOT NULL,
  file_ext TEXT NOT NULL,
  file_source TEXT,
  PRIMARY KEY(id AUTOINCREMENT)
);

CREATE TABLE tags (
  id INTEGER NOT NULL UNIQUE,
  tag TEXT NOT NULL,
  category INTEGER NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT)
);

CREATE TABLE exercise_muscle_tags (
  id INTEGER NOT NULL UNIQUE,
  exercise_id INTEGER NOT NULL,
  tag_id INTEGER NOT NULL,
  FOREIGN KEY(exercise_id) REFERENCES exercises(id),
  FOREIGN KEY(tag_id) REFERENCES tags(id),
  PRIMARY KEY(id AUTOINCREMENT)
);

CREATE TABLE exercise_equipment_tags (
  id INTEGER NOT NULL UNIQUE,
  exercise_id INTEGER NOT NULL,
  tag_id INTEGER NOT NULL,
  FOREIGN KEY(exercise_id) REFERENCES exercises(id),
  FOREIGN KEY(tag_id) REFERENCES tags(id),
  PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
  tags (id, tag, category)
VALUES
  (1, 'chest', 1);

INSERT INTO
  tags (id, tag, category)
VALUES
  (2, 'back', 1);

INSERT INTO
  tags (id, tag, category)
VALUES
  (3, 'shoulders', 1);

INSERT INTO
  tags (id, tag, category)
VALUES
  (4, 'arms', 1);

INSERT INTO
  tags (id, tag, category)
VALUES
  (5, 'legs', 1);

INSERT INTO
  tags (id, tag, category)
VALUES
  (6, 'abs', 1);

INSERT INTO
  tags (id, tag, category)
VALUES
  (7, 'cardio', 1);

INSERT INTO
  tags (id, tag, category)
VALUES
  (8, 'bodyweight', 2);

INSERT INTO
  tags (id, tag, category)
VALUES
  (9, 'freeweight', 2);

INSERT INTO
  tags (id, tag, category)
VALUES
  (10, 'machine', 2);

INSERT INTO
  exercises (
    id,
    name,
    description,
    submitted_by,
    date_submitted,
    approved,
    file_name,
    file_ext,
    file_source
  )
VALUES
  (
    1,
    'Bench Press',
    'Grows the muscles',
    'Chris',
    '3/27/23',
    1,
    '1',
    'jpg',
    'https://mountaindogdiet.com/john/john-meadows/'
  );

INSERT INTO
  exercise_muscle_tags (id, exercise_id, tag_id)
VALUES
  (1, 1, 1);

INSERT INTO
  exercise_equipment_tags (id, exercise_id, tag_id)
VALUES
  (1, 1, 9);

INSERT INTO
  exercises (
    id,
    name,
    description,
    submitted_by,
    date_submitted,
    approved,
    file_name,
    file_ext,
    file_source
  )
VALUES
  (
    2,
    'Squat',
    'Grows the muscles',
    'Chris',
    '3/27/23',
    1,
    '2',
    'jpg',
    'https://mountaindogdiet.com/john/john-meadows/'
  );

INSERT INTO
  exercise_muscle_tags (id, exercise_id, tag_id)
VALUES
  (2, 2, 5);

INSERT INTO
  exercise_equipment_tags (id, exercise_id, tag_id)
VALUES
  (2, 2, 9);

INSERT INTO
  exercises (
    id,
    name,
    description,
    submitted_by,
    date_submitted,
    approved,
    file_name,
    file_ext,
    file_source
  )
VALUES
  (
    3,
    'Deadlift',
    'Grows the muscles',
    'Chris',
    '3/27/23',
    1,
    '3',
    'jpg',
    'https://mountaindogdiet.com/john/john-meadows/'
  );

INSERT INTO
  exercise_muscle_tags (id, exercise_id, tag_id)
VALUES
  (3, 3, 2);

INSERT INTO
  exercise_equipment_tags (id, exercise_id, tag_id)
VALUES
  (3, 3, 9);

INSERT INTO
  exercises (
    id,
    name,
    description,
    submitted_by,
    date_submitted,
    approved,
    file_name,
    file_ext,
    file_source
  )
VALUES
  (
    4,
    'Bicep Curl',
    'Grows the muscles',
    'Chris',
    '3/27/23',
    1,
    '4',
    'jpg',
    'https://mountaindogdiet.com/john/john-meadows/'
  );

INSERT INTO
  exercise_muscle_tags (id, exercise_id, tag_id)
VALUES
  (4, 4, 4);

INSERT INTO
  exercise_equipment_tags (id, exercise_id, tag_id)
VALUES
  (4, 4, 9);

INSERT INTO
  exercises (
    id,
    name,
    description,
    submitted_by,
    date_submitted,
    approved,
    file_name,
    file_ext,
    file_source
  )
VALUES
  (
    5,
    'Cable Fly',
    'Grows the muscles',
    'Chris',
    '3/27/23',
    1,
    '5',
    'jpg',
    'https://mountaindogdiet.com/john/john-meadows/'
  );

INSERT INTO
  exercise_muscle_tags (id, exercise_id, tag_id)
VALUES
  (5, 5, 1);

INSERT INTO
  exercise_equipment_tags (id, exercise_id, tag_id)
VALUES
  (5, 5, 10);

INSERT INTO
  exercises (
    id,
    name,
    description,
    submitted_by,
    date_submitted,
    approved,
    file_name,
    file_ext,
    file_source
  )
VALUES
  (
    6,
    'Barbell Row',
    'Grows the muscles',
    'Chris',
    '3/27/23',
    1,
    '6',
    'jpg',
    'https://mountaindogdiet.com/john/john-meadows/'
  );

INSERT INTO
  exercise_muscle_tags (id, exercise_id, tag_id)
VALUES
  (6, 6, 2);

INSERT INTO
  exercise_equipment_tags (id, exercise_id, tag_id)
VALUES
  (6, 6, 9);

INSERT INTO
  exercises (
    id,
    name,
    description,
    submitted_by,
    date_submitted,
    approved,
    file_name,
    file_ext,
    file_source
  )
VALUES
  (
    7,
    'Shoulder Press',
    'Grows the muscles',
    'Chris',
    '3/27/23',
    1,
    '7',
    'jpg',
    'https://mountaindogdiet.com/john/john-meadows/'
  );

INSERT INTO
  exercise_muscle_tags (id, exercise_id, tag_id)
VALUES
  (7, 7, 3);

INSERT INTO
  exercise_equipment_tags (id, exercise_id, tag_id)
VALUES
  (7, 7, 9);

INSERT INTO
  exercises (
    id,
    name,
    description,
    submitted_by,
    date_submitted,
    approved,
    file_name,
    file_ext,
    file_source
  )
VALUES
  (
    8,
    'Tricep Push Down',
    'Grows the muscles',
    'Chris',
    '3/27/23',
    1,
    '8',
    'jpg',
    'https://mountaindogdiet.com/john/john-meadows/'
  );

INSERT INTO
  exercise_muscle_tags (id, exercise_id, tag_id)
VALUES
  (8, 8, 4);

INSERT INTO
  exercise_equipment_tags (id, exercise_id, tag_id)
VALUES
  (8, 8, 10);

INSERT INTO
  exercises (
    id,
    name,
    description,
    submitted_by,
    date_submitted,
    approved,
    file_name,
    file_ext,
    file_source
  )
VALUES
  (
    9,
    'Walking Lunge',
    'Grows the muscles',
    'Chris',
    '3/27/23',
    1,
    '9',
    'jpg',
    'https://mountaindogdiet.com/john/john-meadows/'
  );

INSERT INTO
  exercise_muscle_tags (id, exercise_id, tag_id)
VALUES
  (9, 9, 5);

INSERT INTO
  exercise_equipment_tags (id, exercise_id, tag_id)
VALUES
  (9, 9, 9);

INSERT INTO
  exercises (
    id,
    name,
    description,
    submitted_by,
    date_submitted,
    approved,
    file_name,
    file_ext,
    file_source
  )
VALUES
  (
    10,
    'Romanian Deadlift',
    'Grows the muscles',
    'Chris',
    '3/27/23',
    1,
    '10',
    'jpg',
    'https://mountaindogdiet.com/john/john-meadows/'
  );

INSERT INTO
  exercise_muscle_tags (id, exercise_id, tag_id)
VALUES
  (10, 10, 5);

INSERT INTO
  exercise_equipment_tags (id, exercise_id, tag_id)
VALUES
  (10, 10, 9);

INSERT INTO
  exercises (
    id,
    name,
    description,
    submitted_by,
    date_submitted,
    approved,
    file_name,
    file_ext,
    file_source
  )
VALUES
  (
    11,
    'Lateral Raise',
    'Grows the muscles',
    'Chris',
    '3/27/23',
    1,
    '11',
    'jpg',
    'https://mountaindogdiet.com/john/john-meadows/'
  );

INSERT INTO
  exercise_muscle_tags (id, exercise_id, tag_id)
VALUES
  (11, 11, 3);

INSERT INTO
  exercise_equipment_tags (id, exercise_id, tag_id)
VALUES
  (11, 11, 9);

--- Users ---
CREATE TABLE users (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL,
  email TEXT NOT NULL,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT)
);

-- password: monkey // is administrator
INSERT INTO
  users (id, name, email, username, password)
VALUES
  (
    1,
    'Chris',
    'cg545@cornell.edu',
    'Chris',
    '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.' -- monkey
  );

-- password: monkey // is not an admin
INSERT INTO
  users (id, name, email, username, password)
VALUES
  (
    2,
    'User',
    'email@example.com',
    'User',
    '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.' -- monkey
  );

--- Sessions ---
CREATE TABLE sessions (
  id INTEGER NOT NULL UNIQUE,
  user_id INTEGER NOT NULL,
  session TEXT NOT NULL UNIQUE,
  last_login TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY(user_id) REFERENCES users(id)
);

--- Groups ----
CREATE TABLE groups (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL UNIQUE,
  PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
  groups (id, name)
VALUES
  (1, 'admin');

--- Group Membership ---
CREATE TABLE user_groups (
  id INTEGER NOT NULL UNIQUE,
  user_id INTEGER NOT NULL,
  group_id INTEGER NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY(group_id) REFERENCES groups(id),
  FOREIGN KEY(user_id) REFERENCES users(id)
);

-- User 'Chris' is a member of the 'admin' group.
INSERT INTO
  user_groups (user_id, group_id)
VALUES
  (1, 1);
