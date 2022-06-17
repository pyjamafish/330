<?php
/**
 * This file defines constants that the other files can use.
 * DATA_ROOT specifies the root directory for the data files.
 */

const DATA_ROOT = "/srv/data/file-sharing";

const QUOTA_BYTES = 2000000;

class InvalidUsernameException extends Exception {}

class InvalidFilenameException extends Exception {}

class QuotaExceededException extends Exception {}

class FileTooLargeException extends Exception {}

/**
 * Throw an InvalidUsernameException if the file name
 * has characters besides alphanumerics, underscores, dashes.
 * @throws InvalidUsernameException
 */
function assert_valid_username($username) {
    if( !preg_match('/^[\w\-]+$/', $username) ) {
        throw new InvalidUsernameException;
    }
}
/**
 * Throw an InvalidFilenameException if the file name
 * has characters besides alphanumerics, underscores, dots, dashes, spaces.
 * @throws InvalidFilenameException
 */
function assert_valid_filename($filename) {
    # Regex modified from the 330 wiki to allow spaces.
    if (!preg_match('/^[\w.\- ]+$/', $filename)) {
        throw new InvalidFilenameException;
    }
}
