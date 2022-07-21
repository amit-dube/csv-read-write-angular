import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditCsvDataComponent } from './edit-csv-data.component';

describe('EditCsvDataComponent', () => {
  let component: EditCsvDataComponent;
  let fixture: ComponentFixture<EditCsvDataComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ EditCsvDataComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(EditCsvDataComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
