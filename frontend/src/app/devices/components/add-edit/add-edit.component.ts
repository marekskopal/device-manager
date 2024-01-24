import {Component, Input, OnInit} from '@angular/core';
import {UntypedFormBuilder, Validators} from '@angular/forms';
import {first} from 'rxjs/operators';

import {AlertService, DeviceService} from '@app/services';
import {NgbActiveModal} from "@ng-bootstrap/ng-bootstrap";
import {BaseForm} from "@app/shared/components/form/base-form";
import {DeviceTypeEnum, OsEnum, Owner} from "@app/models";
import {OwnerService} from "@app/services/owner.service";

@Component({ templateUrl: 'add-edit.component.html' })
export class AddEditComponent extends BaseForm implements OnInit {
    @Input() public id: number;
    public isAddMode: boolean;
    public deviceTypes = [
        {name: 'Pc', key: DeviceTypeEnum.Pc},
        {name: 'Laptop', key: DeviceTypeEnum.Laptop},
        {name: 'Mobile', key: DeviceTypeEnum.Mobile},
    ]
    public operationSystems = [
        {name: 'Windows', key: OsEnum.Windows},
        {name: 'Linux', key: OsEnum.Linux},
        {name: 'MacOS', key: OsEnum.MacOS},
        {name: 'iOS', key: OsEnum.IOS},
        {name: 'Android', key: OsEnum.Android},
    ]
    public owners: Owner[];

    public constructor(
        private deviceService: DeviceService,
        private ownerService: OwnerService,
        public activeModal: NgbActiveModal,
        formBuilder: UntypedFormBuilder,
        alertService: AlertService,
    ) {
        super(formBuilder, alertService)
    }

    public ngOnInit(): void {
        this.isAddMode = !this.id;

        this.ownerService.getOwners()
            .subscribe((owners: Owner[]) => {
                this.owners = owners;
            });

        this.form = this.formBuilder.group({
            hostname: ['', Validators.required],
            type: [DeviceTypeEnum.Pc, Validators.required],
            os: [OsEnum.Windows, Validators.required],
            ownerId: ['', Validators.required],
        });

        if (!this.isAddMode) {
            this.deviceService.getDevice(this.id)
                .pipe(first())
                .subscribe(x => this.form.patchValue(x));
        }
    }

    public onSubmit(): void {
        this.submitted = true;

        // reset alerts on submit
        this.alertService.clear();

        // stop here if form is invalid
        if (this.form.invalid) {
            return;
        }

        this.loading = true;
        if (this.isAddMode) {
            this.createDevice();
        } else {
            this.updateDevice();
        }
    }

    private createDevice(): void {
        this.deviceService.createDevice(this.form.value)
            .pipe(first())
            .subscribe({
                next: () => {
                    this.alertService.success('Device added successfully', { keepAfterRouteChange: true });
                    this.activeModal.dismiss();
                    this.deviceService.notify();
                },
                error: error => {
                    this.alertService.error(error);
                    this.loading = false;
                }
            });
    }

    private updateDevice(): void {
        this.deviceService.updateDevice(this.id, this.form.value)
            .pipe(first())
            .subscribe({
                next: () => {
                    this.alertService.success('Update successful', { keepAfterRouteChange: true });
                    this.activeModal.dismiss();
                    this.deviceService.notify();
                },
                error: error => {
                    this.alertService.error(error);
                    this.loading = false;
                }
            });
    }
}
