DROP TABLE IF EXISTS branches;
CREATE TABLE branches (
	id INTEGER PRIMARY KEY,
	name VARCHAR(255),
	parent_id INTEGER
);

INSERT INTO branches(name, parent_id) VALUES('disk', 0);
INSERT INTO branches(name, parent_id) VALUES('disk2', 0);

INSERT INTO branches(name, parent_id) VALUES('folder', 1);
INSERT INTO branches(name, parent_id) VALUES('folder2', 1);
INSERT INTO branches(name, parent_id) VALUES('folder3', 1);
INSERT INTO branches(name, parent_id) VALUES('dir1', 1);
INSERT INTO branches(name, parent_id) VALUES('dir2', 1);
INSERT INTO branches(name, parent_id) VALUES('dir3', 1);
INSERT INTO branches(name, parent_id) VALUES('mydir', 1);
INSERT INTO branches(name, parent_id) VALUES('myfolder', 1);

INSERT INTO branches(name, parent_id) VALUES('subdir', 3);
INSERT INTO branches(name, parent_id) VALUES('subdir2', 3);
INSERT INTO branches(name, parent_id) VALUES('subdir3', 3);

INSERT INTO branches(name, parent_id) VALUES('subfolder', 5);
INSERT INTO branches(name, parent_id) VALUES('subfolder1', 5);
INSERT INTO branches(name, parent_id) VALUES('subfolder2', 5);

INSERT INTO branches(name, parent_id) VALUES('dir2', 2);
INSERT INTO branches(name, parent_id) VALUES('dir2', 2);
INSERT INTO branches(name, parent_id) VALUES('dir3', 2);
INSERT INTO branches(name, parent_id) VALUES('mydir', 2);
INSERT INTO branches(name, parent_id) VALUES('myfolder', 2);
