<?php

trait Modules_NimbusecAgentIntegration_FormatTrait
{
    public function formatPermission($permissions)
    {
        // skip file type
        if (strlen($permissions) > 3) {
            $permissions = substr($permissions, -3);
        }

        $scopes = str_split($permissions);
		
        $human = "";
        foreach ($scopes as $scope) {
            $human .= (intval($scope) >= 4) ? "r" : "-";
            $human .= (intval($scope) >= 2) ? "w" : "-";
            $human .= (intval($scope) >= 1) ? "x" : "-";
        }

        return $human;
    }

    public function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ["B", "KB", "MB", "GB", "TB"];

        return round(pow(1024, $base - floor($base)), $precision) . " " . $suffixes[floor($base)];
    }
}