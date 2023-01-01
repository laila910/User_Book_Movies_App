import { Component,OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ApiService } from 'src/app/api.service';
@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit{
  id = this._route.snapshot.params['id'];
  userData:any;
  userInfo:any;

  ngOnInit(): void {
    this.userData=localStorage.getItem('userData');

    this.userInfo=JSON.parse(this.userData);
 
    
  }
  constructor(public _route:ActivatedRoute,private router:Router,public myService:ApiService){}

}
