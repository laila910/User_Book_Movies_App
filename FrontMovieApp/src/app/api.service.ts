import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class ApiService {
  public IMG_URL="http://127.0.0.1:8000/images/";

  public base_url="http://127.0.0.1:8000/api/v1";
  public token= localStorage.getItem('appToken');


  constructor(private http:HttpClient) { }
  

  login(data:any):Observable<any>{
    return this.http.post(`${this.base_url}/login`,data);
  }

  register(data:any):Observable<any>{
    return this.http.post(`${this.base_url}/register`,data);
  }
  getAllMovies():Observable<any>{
    return this.http.get(`${this.base_url}/movies`);
  }
  getMovie(id:number):Observable<any>{
    return this.http.get(`${this.base_url}/movies/${id}`);
  }
  //protected routes for any user

  // Book A ticket For Specific Movie
  bookTicket(id:number,data:any):Observable<any>{
    return this.http.post(`${this.base_url}/${id}/bookTicket`,data);
  } 
  
  updateUserData(id:number,data:any):Observable<any>{
    return this.http.put(`${this.base_url}/users/${id}`,data);
  }

  logout(data:any):Observable<any>{
    return this.http.post(`${this.base_url}/logout`,data);//temporary hana5od data of user
  }
  //protected routes for admin
  storeMovie(data:any):Observable<any>{
    return this.http.post(`${this.base_url}/movies`,data);
  }
  updateMovie(id:number,data:any):Observable<any>{
    return this.http.put(`${this.base_url}/movies/${id}`,data);
  }
  deleteMovie(id:number):Observable<any>{
    return this.http.delete(`${this.base_url}/movies/${id}`);
  }
  
  getAllUsers():Observable<any>{
    return this.http.get(`${this.base_url}/users`);
  }
  // getUserData(id:number):Observable<any>{
  //   return this.http.get(`${this.base_url}/users/${id}`);
  // }
  
   //add Movie Show-Time to specific Movie
   addShowTimetoMovie(id:number,data:any):Observable<any>{
    return this.http.post(`${this.base_url}/${id}/addmovieShowTime`,data);
   }
   
     // Export All Movies Into Excel
     exportAllMoviesUserIntoExcel():Observable<any>{
      return this.http.get(`${this.base_url}/exportIntoExcel`);
     }
      // Export All Movies Into CSV
      exportAllMoviesUsersIntoCSV():Observable<any>{
        return this.http.get(`${this.base_url}/exportIntoCSV`);
      }
      // Export Specific User-Movie Details into Excel
      exportUserMoviesofSpecificMovieIntoExcel(id:number):Observable<any>{
        return this.http.get(`${this.base_url}/${id}/exportExcel`);
      }
      // Export Specific User-Movie Details into CSV
      exportUserMoviesofSpecificMovieIntoCSV(id:number):Observable<any>{
        return this.http.get(`${this.base_url}/${id}/exportCSV`);
      }
       // Export Specific User-Movie Details into Pdf
       DownloadUserMoviesIntoPdf(id:number):Observable<any>{
        return this.http.get(`${this.base_url}/${id}/DownloadPDF`);
       }



}
