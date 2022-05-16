<?php


class DateHelper {
    public static function dateDiff($dateEnd,$dateBegin){
        $StartDate;
        $EndDate;
        if (is_integer($dateEnd)) {
            $EndDate = new DateTime(Date('Y-m-d',$dateEnd));
        } 
        elseif (is_string($dateEnd)) {
            $EndDate = DateTime::createFromFormat('Y-m-d',$dateEnd);
        }
        else {
            $EndDate = $dateEnd;
        }

        if (is_integer($dateBegin)) {
            $StartDate = new DateTime(Date('Y-m-d',$dateBegin));
        }
        elseif 
            (is_string($dateBegin)) {
            $StartDate = DateTime::createFromFormat('Y-m-d',$dateBegin);
        }
        else {
            $StartDate = $dateBegin;
        }

    $EndDate->setTime(0,0,0);
    $StartDate->setTime(0,0,0);
        
        
        $interval = $EndDate->diff($StartDate);
 //$interval=$EndDate->diff($StartDate)->format("%d");

        //if (is_string($dateEnd)) {
        //    $dateEnd = strtotime($dateEnd);
        //}
        //if (is_string($dateBegin)) {
        //    $dateBegin = strtotime($dateBegin);
        //}
        
        //$subTime = $dateEnd - $dateBegin;
        //$DiffYear=(date("Y",$dateEnd)-date("Y",$dateBegin));
        //return ($subTime/(60*60*24))%365 + ($DiffYear * 365);
//        return $DiffYear;
        return $interval->days +1;
//return $interval+1;

        }  
      
    public static function monthDiff($dateEnd,$dateBegin){
        $StartDate;
        $EndDate;
        if (is_integer($dateEnd)) {
            $EndDate = new DateTime(Date('Y-m-d',$dateEnd));
        } 
        elseif (is_string($dateEnd)) {
            $EndDate = DateTime::createFromFormat('Y-m-d',$dateEnd);
        }
        else {
            $EndDate = $dateEnd;
        }

        if (is_integer($dateBegin)) {
            $StartDate = new DateTime(Date('Y-m-d',$dateBegin));
        }
        elseif 
            (is_string($dateBegin)) {
            $StartDate = DateTime::createFromFormat('Y-m-d',$dateBegin);
        }
        else {
            $StartDate = $dateBegin;
        }
        
        
        $interval = $EndDate->diff($StartDate);
 

        ////if (is_string($dateEnd)) {
        ////    $dateEnd = strtotime($dateEnd);
        ////}
        ////if (is_string($dateBegin)) {
        ////    $dateBegin = strtotime($dateBegin);
        ////}
        
        ////$subTime = $dateEnd - $dateBegin;
        ////$DiffYear=(date("Y",$dateEnd)-date("Y",$dateBegin));
        ////return ($subTime/(60*60*24))%365 + ($DiffYear * 365);
        ////        return $DiffYear;
        //return $interval->months;
        //$StartMonth= date("n",$dateBegin );
        //$EndMonth= date("n",$dateEnd); 
        //$DiffMonth = $EndMonth - $StartMonth;
        //$DiffYear=(date("Y",$dateEnd)-date("Y",$dateBegin)) * 12;
        //return $DiffYear + $DiffMonth;
        if (floor($EndDate->format('d')) < floor($StartDate->format('d')))
        {    //the condition was           if (floor($EndDate->format('d')) <= floor($StartDate->format('d')))
           

             return ($interval->format('%y') * 12) + $interval->format('%m')+1 ;
        }
        else {
            return ($interval->format('%y') * 12) + $interval->format('%m');
        }
        }
    
    public static function yearDiff($dateEnd,$dateBegin){
        $StartDate;
        $EndDate;
        if (is_integer($dateEnd)) {
            $EndDate = new DateTime(Date('Y-m-d',$dateEnd));
        } 
        elseif (is_string($dateEnd)) {
            $EndDate = DateTime::createFromFormat('Y-m-d',$dateEnd);
        }
        else {
            $EndDate = $dateEnd;
        }

        if (is_integer($dateBegin)) {
            $StartDate = new DateTime(Date('Y-m-d',$dateBegin));
        }
        elseif 
            (is_string($dateBegin)) {
            $StartDate = DateTime::createFromFormat('Y-m-d',$dateBegin);
        }
        else {
            $StartDate = $dateBegin;
        }
        
        
        $interval = $EndDate->diff($StartDate);
        

        ////if (is_string($dateEnd)) {
        ////    $dateEnd = strtotime($dateEnd);
        ////}
        ////if (is_string($dateBegin)) {
        ////    $dateBegin = strtotime($dateBegin);
        ////}
        
        ////$subTime = $dateEnd - $dateBegin;
        ////$DiffYear=(date("Y",$dateEnd)-date("Y",$dateBegin));
        ////return ($subTime/(60*60*24))%365 + ($DiffYear * 365);
        ////        return $DiffYear;
        //return $interval->months;
        //$StartMonth= date("n",$dateBegin );
        //$EndMonth= date("n",$dateEnd); 
        //$DiffMonth = $EndMonth - $StartMonth;
        //$DiffYear=(date("Y",$dateEnd)-date("Y",$dateBegin)) * 12;
        //return $DiffYear + $DiffMonth;
        return $interval->format('%y');
    }

    
    
    public static function createDateList($StartDate,$EndDate) {
        if (is_string($StartDate)) {
            $StartDate = DateTime::createFromFormat('Y-m-d',$StartDate);
        }
        if (is_string($EndDate)) {
            $EndDate = DateTime::createFromFormat('Y-m-d',$EndDate);
        }


	$DateList=array();
        $TmpDate= DateTime::createFromFormat('Y-m-d',$StartDate->format('Y-m-d'));
        array_push($DateList,$TmpDate->format('Y-m-d'));
        do
    {
        $TmpDate->add(new DateInterval('P1D'));
        array_push($DateList,$TmpDate->format('Y-m-d'));
    } while($TmpDate<$EndDate);
    
     return $DateList;   
    
    }
    
    

}
