<?php

namespace App\CustomClass;

class ReturnMessage
{
    public static function customMessage($type, $sms)
    {
        return redirect()->back()->with($type, $sms);
    }

    public static function insertSuccess()
    {
        return redirect()->back()->with('success', 'Data saved successfully!');
    }

    public static function updateSuccess()
    {
        return redirect()->back()->with('success', 'Data updated successfully!');
    }

    public static function deleteSuccess()
    {
        return redirect()->back()->with('success', 'Data deleted successfully!');
    }

    public static function duplicate()
    {
        return redirect()->back()->with('error', 'Duplicate records found!');
    }

    public static function tokenExpire()
    {
        return redirect()->back()->with('error', 'Duplicate token found!');
    }

    public static function somethingWrong()
    {
        return redirect()->back()->with('error', 'Something wrong!');
    }

    public static function customMessageSuccess($data)
    {
        return redirect()->back()->with('success', $data);
    }

    public static function jsonInsertSuccess()
    {
        return response()->json(['status' => 'success', 'message' => 'Data saved successfully !']);
    }

    public static function jsonUpdateSuccess()
    {
        return response()->json(['status' => 'success', 'message' => 'Data updated successfully !']);
    }

    public static function jsonDeleteSuccess()
    {
        return response()->json(['status' => 'success', 'message' => 'Data deleted successfully !']);
    }

    public static function jsonDuplicate()
    {
        return response()->json(['status' => 'error', 'message' => 'Duplicate records found !']);
    }

    public static function jsonDeleteException()
    {
        return response()->json(['status' => 'error', 'message' => 'Already used. can\'t delete it.']);
    }

    public static function jsonSomethingWrong()
    {
        return response()->json(['status' => 'error', 'message' => 'Something wrong!']);
    }
}