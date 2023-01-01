import { Component, OnInit } from '@angular/core';
import { ApiService } from 'src/app/api.service';
import { Router } from '@angular/router';
import { FormGroup, FormControl, Validators } from '@angular/forms';


@Component({
  selector: 'app-movies-home',
  templateUrl: './movies-home.component.html',
  styleUrls: ['./movies-home.component.css']
})
export class MoviesHomeComponent implements OnInit {
  movies: any;
 


  constructor(public myService: ApiService) {
   
  }

  ngOnInit(): void {
  
    this.myService.getAllMovies().subscribe({
      next: (data) => (this.movies = data),
      error: (err) => console.error(err),
    });

   
  }

 

}
