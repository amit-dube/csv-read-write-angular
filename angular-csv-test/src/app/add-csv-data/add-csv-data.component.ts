import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { CovidService } from './../covid.service';
import { CSVRecord } from './../CSVModel';

@Component({
  selector: 'app-add-csv-data',
  templateUrl: './add-csv-data.component.html',
  styleUrls: ['./add-csv-data.component.css']
})
export class AddCsvDataComponent implements OnInit {
  id: number = 0;
  form!: FormGroup;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private fb: FormBuilder,
    private csvService: CovidService
    ) {}

    ngOnInit(): void {
      this.form = new FormGroup({
        name: new FormControl('', [ Validators.required, Validators.minLength(3), Validators.pattern(/^[a-zA-Z\s]*$/)]),
        state: new FormControl('', [Validators.required, Validators.minLength(2), Validators.pattern(/^[a-zA-Z\s]*$/)]),
        zip: new FormControl('', [Validators.required, Validators.minLength(4), Validators.pattern(/^[0-9]+$/)]),
        amount: new FormControl('', [Validators.required, Validators.minLength(2), Validators.pattern(/^\d+\.?\d*$/)]),
        qty: new FormControl('', [Validators.required, Validators.minLength(1), Validators.pattern(/^[0-9]+$/)]),
        item: new FormControl('', [Validators.required, Validators.minLength(3)])
      });
    }

    get f(){
      return this.form.controls;
    }

    submit(){
         this.csvService.addCsvData(this.form.value).subscribe(res=>{
        console.log('Post created successfully');
        this.router.navigateByUrl('/')
      })
    }

}
