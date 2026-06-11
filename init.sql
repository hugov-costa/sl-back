-- Create database if it doesn't exist
IF NOT EXISTS (SELECT * FROM sys.databases WHERE name = 'softline')
BEGIN
    CREATE DATABASE softline;
END
GO
