WITH SubdivisionHierarchy AS (
    SELECT id, name, parent_id, 0 AS sub_level
    FROM subdivisions
    WHERE id = 710253

    UNION ALL

    SELECT s.id, s.name, s.parent_id, sh.sub_level + 1
    FROM subdivisions s
    INNER JOIN SubdivisionHierarchy sh ON s.parent_id = sh.id
),
FilteredEmployees AS (
    SELECT c.id, c.name, c.subdivision_id, c.age
    FROM colaboradores c
    JOIN SubdivisionHierarchy sh ON c.subdivision_id = sh.id
    WHERE c.age < 40 AND LEN(c.name) > 11
),
SubdivisionEmployeesCount AS (
    SELECT sh.id AS sub_id, COUNT(fe.id) AS Colls_count
    FROM SubdivisionHierarchy sh
    LEFT JOIN FilteredEmployees fe ON sh.id = fe.subdivision_id
    GROUP BY sh.id
)
SELECT
    fe.id,
    fe.name,
    s.name AS sub_name,
    fe.subdivision_id AS sub_id,
    sh.sub_level AS sub_level,
    sec.Colls_count
FROM FilteredEmployees fe
JOIN SubdivisionHierarchy sh ON fe.subdivision_id = sh.id
JOIN subdivisions s ON fe.subdivision_id = s.id
LEFT JOIN SubdivisionEmployeesCount sec ON fe.subdivision_id = sec.sub_id
WHERE s.id NOT IN (100055, 100059)
ORDER BY sh.sub_level;