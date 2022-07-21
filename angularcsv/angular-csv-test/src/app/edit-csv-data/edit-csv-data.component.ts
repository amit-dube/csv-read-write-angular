import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { CovidService } from './../covid.service';
import { CSVRecord } from './../CSVModel';

@Component({
  selector: 'app-edit-csv-data',
  templateUrl: './edit-csv-data.component.html',
  styleUrls: ['./edit-csv-data.component.css']
})
export class EditCsvDataComponent implements OnInit {

  id!: number;
  form!: FormGroup;
  public post: any;
  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private fb: FormBuilder,
    private csvService: CovidService
  ) { }

  ngOnInit(): void {
    this.id = this.route.snapshot.params['id'];
    //this.getDataById();

    this.form = new FormGroup({
      id: new FormControl(this.id),
      name: new FormControl('test amit', [ Validators.required, Validators.minLength(3), Validators.pattern(/^[a-zA-Z\s]*$/)]),
      state: new FormControl('karnataka', [Validators.required, Validators.minLength(2), Validators.pattern(/^[a-zA-Z\s]*$/)]),
      zip: new FormControl('560068', [Validators.required, Validators.minLength(4), Validators.pattern(/^[0-9]+$/)]),
      amount: new FormControl('3000', [Validators.required, Validators.minLength(2), Validators.pattern(/^\d+\.?\d*$/)]),
      qty: new FormControl('30', [Validators.required, Validators.minLength(1), Validators.pattern(/^[0-9]+$/)]),
      item: new FormControl('1234', [Validators.required, Validators.minLength(3),Validators.pattern("^[a-zA-Z0-9_]*$")])
    });
  }

  

  get f(){
    return this.form.controls;
  }

  submit(){
    console.log(this.form.value);

    this.csvService.editCsvData(this.form.value).subscribe(res => {

         console.log('Post updated successfully!');

         this.router.navigateByUrl('/')

    })
  }

}
