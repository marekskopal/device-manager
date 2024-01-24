import {Component, Input, OnInit} from '@angular/core';
import {UntypedFormBuilder, Validators} from '@angular/forms';
import {first} from 'rxjs/operators';

import {AlertService} from '@app/services';
import {NgbActiveModal} from "@ng-bootstrap/ng-bootstrap";
import {BaseForm} from "@app/shared/components/form/base-form";
import {Owner} from "@app/models";
import {OwnerService} from "@app/services/owner.service";

@Component({ templateUrl: 'add-edit.component.html' })
export class AddEditComponent extends BaseForm implements OnInit {
    @Input() public id: number;
    public isAddMode: boolean;

    public constructor(
        private ownerService: OwnerService,
        public activeModal: NgbActiveModal,
        formBuilder: UntypedFormBuilder,
        alertService: AlertService,
    ) {
        super(formBuilder, alertService)
    }

    public ngOnInit(): void {
        this.isAddMode = !this.id;

        this.form = this.formBuilder.group({
            firstName: ['', Validators.required],
            lastName: ['', Validators.required],
        });

        if (!this.isAddMode) {
            this.ownerService.getOwner(this.id)
                .pipe(first())
                .subscribe((owner: Owner) => this.form.patchValue(owner));
        }
    }

    public onSubmit(): void {
        this.submitted = true;

        this.alertService.clear();

        if (this.form.invalid) {
            return;
        }

        this.loading = true;
        if (this.isAddMode) {
            this.createOwner();
        } else {
            this.updateOwner();
        }
    }

    private createOwner(): void {
        this.ownerService.createOwner(this.form.value)
            .pipe(first())
            .subscribe({
                next: () => {
                    this.alertService.success('Owner added successfully', { keepAfterRouteChange: true });
                    this.activeModal.dismiss();
                    this.ownerService.notify();
                },
                error: error => {
                    this.alertService.error(error);
                    this.loading = false;
                }
            });
    }

    private updateOwner(): void {
        this.ownerService.updateOwner(this.id, this.form.value)
            .pipe(first())
            .subscribe({
                next: () => {
                    this.alertService.success('Update successful', { keepAfterRouteChange: true });
                    this.activeModal.dismiss();
                    this.ownerService.notify();
                },
                error: error => {
                    this.alertService.error(error);
                    this.loading = false;
                }
            });
    }
}
