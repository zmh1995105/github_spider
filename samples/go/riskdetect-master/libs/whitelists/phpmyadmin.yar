import "hash"

private rule safe_Phpmyadmin
{
    strings:
        $test = "test"
    condition:
        $test
}