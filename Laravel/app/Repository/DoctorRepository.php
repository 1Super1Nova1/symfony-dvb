<?php
 
 namespace App\Repository;
 
 use App\Models\Doctors;
 use Illuminate\Contracts\Pagination\LengthAwarePaginator;
 
 class DoctorRepository
 {
 
     /**
      * @param array $params
      * @param int $itemsPerPage
      * @return LengthAwarePaginator
      */
     public function getDoctors(array $params, int $itemsPerPage): LengthAwarePaginator
     {
         $query = Doctors::query();
 
         $this->mapParams($query, $params);
 
         return $query->paginate($itemsPerPage);
     }
 
 
     /**
      * @param $query
      * @param array $params
      * @return void
      */
     private function mapParams($query, array $params): void
     {
         foreach ($params as $key => $value) {
 
             $ourKey = $key;
             $ourValue = $value;
 
             if (is_array($value)) {
                 $ourKey = $key . ucfirst(array_key_first($value));
                 $ourValue = $value[array_key_first($value)];
             }
 
             $query->where($ourKey, 'LIKE', "%" . $ourValue . "%" ?? null);
 
         } 
     } 
 }