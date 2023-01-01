import { Component,OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ApiService } from 'src/app/api.service';



@Component({
  selector: 'app-movie-details',
  templateUrl: './movie-details.component.html',
  styleUrls: ['./movie-details.component.css']
})
export class MovieDetailsComponent implements OnInit{
  id = this._route.snapshot.params['id'];
  movieData:any;
  admin:boolean=false;
  userData:any;
  userInfo:any;

  ngOnInit(): void {
    this.myService.getMovie(this.id).subscribe(data=>{
      console.log(data.data);
      this.movieData=data.data;
    },(e)=>{console.log(e)},
    ()=>{
      
    });
    this.userData=localStorage.getItem('userData');
    this.userInfo=JSON.parse(this.userData);
    if(this.userInfo.email='lailaibrahim798@gmail.com'){
      this.admin=true;
    }
    
    
  }
  constructor(public _route:ActivatedRoute,private router:Router,public myService:ApiService){}

}
