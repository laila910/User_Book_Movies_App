import { Component, OnInit, NgModule } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { ApiService } from '../api.service';


@Component({
  selector: 'app-book-ticket',
  templateUrl: './book-ticket.component.html',
  styleUrls: ['./book-ticket.component.css']
})
export class BookTicketComponent implements OnInit{
  userData:any;
 userInfo:any;
 movieData:any;
flag:boolean=false;
 id = this._route.snapshot.params['id'];

  bookTicketForm = new FormGroup({
    ticketsNumbers: new FormControl('', [Validators.required]),
    datetime:new FormControl('',[Validators.required])
  });
  message:any;
  book(data:any){
    console.log(data.value.ticketsNumbers);
    this.myService.bookTicket(this.id,{'movie_id':this.id,'user_id':this.userInfo.id,'ticketsNumbers':data.value.ticketsNumbers,'datetime':data.value.datetime}).subscribe(data=>{
     
    
    },(e)=>{
      console.log(e);
      console.log(e.error.message);
      // this.message=e.error.message;
      // this.flag=true;
    },
    ()=>{

    })

  }
  ngOnInit(): void {
    this.userData= localStorage.getItem('userData');
    this.userInfo=JSON.parse(this.userData);

    this.myService.getMovie(this.id).subscribe(data=>{
      console.log(data.data);
      this.movieData=data.data;

    },(e)=>{console.log(e)},
    ()=>{
      
    });
  }
  constructor(public _route:ActivatedRoute,private router:Router,public myService:ApiService){
    

  }

}
