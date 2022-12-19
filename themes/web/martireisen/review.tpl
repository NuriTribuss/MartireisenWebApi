
<style>
    [type=checkbox]:checked,
    [type=checkbox]:not(:checked) {
        position: absolute;
        left: -9999px
    }

    [type=checkbox]:checked + label,
    [type=checkbox]:not(:checked) + label {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #1c1c1c
    }

    [type=checkbox]:checked + label:before,
    [type=checkbox]:not(:checked) + label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 18px;
        height: 18px;
        border: 1px solid #d0d0d0;
        border-radius: 4px;
        background: #fff
    }

    [type=checkbox]:checked + label:after,
    [type=checkbox]:not(:checked) + label:after {
        content: '';
        width: 18px;
        height: 18px;
        background: #f7a534;
        position: absolute;
        top: 0;
        left: 0;
        border-radius: 4px;
        -webkit-transition: all .2s ease;
        transition: all .2s ease
    }

    [type=checkbox]:checked + label:before {
        border-color: #f7a534 !important
    }

    [type=checkbox]:not(:checked) + label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        transform: scale(0)
    }

    [type=checkbox]:checked + label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1)
    }

    .custom-card {
        border: 1px solid rgba(128,137,150,.1);
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        margin-bottom: 30px;
        background-color: #fff;
        box-shadow: 0 0 40px rgb(82 85 90 / 10%);
    }
    .custom-card .padding {
        padding: 20px;
    }
    .cover-area figure {
        position: relative;
        margin:0;
    }
    .cover-area figure img {
        border-radius: 8px;
        min-height: 150px;
        object-fit: cover;
    }
    .cover-area figcaption {
        position: absolute;
        bottom:0;
        left:0;
        display: flex;
        align-items: flex-end;
        flex-wrap: wrap;
        width: 100%;
        height: 100%;
        padding: 20px;
        background: rgb(0,0,0);
        background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 25%, rgba(0,0,0,0) 100%);
        border-radius: 8px;
    }
    .cover-area figcaption h2 {
        font-size: 18px;
        color:#fff;
        display: block;
        font-weight: 600
    }
    .cover-area figcaption p,
    .cover-area figcaption small {
        color:#fff;
        display: block;
        margin: 0;
    }

    .question{
        margin: 10px 0;
        border-top: 1px solid #f1f1f1;
        padding: 20px 30px;
    }
    form.custom-form .question .form-group{
        border: none;
        padding: 0;
        margin-top: 20px;
        margin-bottom: 0
    }
    .question:first-child{
        border: none;
    }
    .question .question-title {
        font-weight: 700;
        font-size: 20px;
        letter-spacing: -0.34px
    }
    .question .question-title+small{
        font-size: 14px;
    }
    .question label {
        font-size: 16px;
        font-weight: 500
    }
    .question .form-group {
        margin-top: 10px;
        margin-bottom: 0;
    }
    .question .form-item {
        margin: 6px 0 0 0 !important;
    }
    .question .form-item label{
        margin: 0;
    }
    .btn-group label:after,
    .btn-group label:before{
        display:none;
    }
    .btn-group.white{
        justify-content: space-between;
        width: 100%;
    }
    .btn-group.white>.btn{
        background-color: transparent !important;
        color: #000;
        border: 1px solid #d0d0d0;
        font-weight: 600;
        font-size: 17px;
    }

    .btn-group.white>.btn.active{
        background-color: #173283 !important;
        border-color:#173283 !important;
        box-shadow: none;
    }

    .btn-group.white>.btn.active path{
        fill:#fff
    }

    .fileuploader{
        margin: 0;
    }
    


    @media (max-width: 992px) {
        form.custom-form .form-group .form-item {
            margin-bottom: 5px !important;
        }
    }

    @media (max-width: 767px) {
        .question .question-title {
            font-size: 18px;
        }
        .question label {
            font-size: 14px;
        }
        .btn-group.white>.btn {
            padding: 5px;
            font-size: 14px;
        }
        .question,
        form.custom-form .form-group{
            padding: 10px 15px;
        }
    }
</style>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="custom-card">
                <div class="cover-area">
                    <figure>
                        <img src="https://cf.bstatic.com/xdata/images/hotel/820x250/298682678.webp?k=cbf3cf2e9531c18fb60f2e18bfdd1582855d16cf7bcc5bdd8af65f7167b97198&o=" class="w-100" alt="hotel title" title="hotel title">
                        <figcaption>
                            <div class="description">
                                <h2>La sorgente del sole tesisini değerlendirin</h2>
                                <p>Positano'da 3 gece</p>
                                <small>17 Tem - 20 Tem</small>
                            </div>
                        </figcaption>
                    </figure>
                </div>
                
                <form class="custom-form">
                    <div class="question">
                        <h4 class="question-title">İş için mi seyahat ettiniz?</h4>
                        <div class="form-group">
                            <div class="form-item">
                                <input type="radio" id="question1-1" name="question-1">
                                <label for="question1-1">Hayır</label>
                            </div>
                            <div class="form-item">
                                <input type="radio" id="question1-2" name="question-1">
                                <label for="question1-2">Evet</label>
                            </div>
                        </div>
                    </div>

                    <div class="question">
                        <h4 class="question-title">Kiminle seyahat ettiniz?</h4>
                        <small>Uygun olanların tümünü seçin</small>
                        <div class="form-group">
                            <div class="form-item">
                                <input type="checkbox" id="question2-1" name="question-2">
                                <label for="question2-1">Yalnız</label>
                            </div>
                            <div class="form-item">
                                <input type="checkbox" id="question2-2" name="question-2">
                                <label for="question2-2">Arkadaşlar</label>
                            </div>
                            <div class="form-item">
                                <input type="checkbox" id="Partner" name="question-2">
                                <label for="Partner">Eş</label>
                            </div>
                            <div class="form-item">
                                <input type="checkbox" id="Familie" name="question-2">
                                <label for="Familie">İş Arkadaşları</label>
                            </div>
                            <div class="form-item">
                                <input type="checkbox" id="Kollege" name="question-2">
                                <label for="Kollege">Evcil Hayvan</label>
                            </div>
                        </div>
                    </div>

                    <div class="question">
                        <h4 class="question-title">Tesis beklentilerinizi karşıladı mı?</h4>
                        <div class="form-group">
                            <div class="form-item">
                                <input type="radio" id="question1" name="question-3">
                                <label for="question1">Hayır</label>
                            </div>
                            <div class="form-item">
                                <input type="radio" id="Ja" name="question-3">
                                <label for="Ja">Evet</label>
                            </div>
                            <div class="form-item">
                                <input type="radio" id="sie" name="question-3">
                                <label for="sie">Beklentilerimin üzerindeydi</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="custom-card mt-5">
                <form class="custom-form">
                    <div class="question">
                        <h4 class="question-title">2. Bu tesisi puanlayın:</h4>
                        <p><strong>La sorgente del sole tesisindeki konaklamanız nasıldı?</strong></p>
                        <div class="btn-group btn-group-toggle white" data-toggle="buttons">
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary active">
                                <input type="radio" name="options" id="option1"> 1
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="options" id="option2"> 2
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="options" id="option3"> 3
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="options" id="option4"> 4
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="options" id="option5"> 5
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="options" id="option6"> 6
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="options" id="option7"> 7
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="options" id="option8"> 8
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="options" id="option9"> 9
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="options" id="option10"> 10
                            </label>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <p>Kötü</p>
                            <p>Olağanüstü</p>
                        </div>
                    </div>
                    <div class="question">
                        <p><strong>Ev sahibi/sahipleri</strong></p>
                        <div class="btn-group btn-group-toggle white" data-toggle="buttons">
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="evsahipleri" id="option1">
                                <svg class="bk-icon -iconset-review_poor" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 30.2a4 4 0 1 1-5.6 5.6c-10.5-10.4-24-10.4-34.4 0a4 4 0 0 1-5.6-5.6c13.6-13.7 32-13.7 45.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="evsahipleri" id="option2">
                                <svg class="bk-icon -iconset-review_average" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4 28a4 4 0 0 1-4 4H44a4 4 0 0 1 0-8h40a4 4 0 0 1 4 4z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="evsahipleri" id="option3">
                                <svg class="bk-icon -iconset-review_good" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 21.2a4 4 0 0 1 0 5.6A32 32 0 0 1 64 93.1c-8 0-16-3.4-22.8-10.3a4 4 0 0 1 5.6-5.6c10.5 10.4 24 10.4 34.4 0a4 4 0 0 1 5.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="evsahipleri" id="option4">
                                <svg class="bk-icon -iconset-review_great" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4.8 21.6a4 4 0 0 1 .6 3.6A24.3 24.3 0 0 1 64 97c-9.7 0-15.7-4.2-19-7.8a22.7 22.7 0 0 1-4.8-8A4 4 0 0 1 44 76h40a4 4 0 0 1 3.2 1.6z"></path></svg>
                            </label>
                        </div>
                    </div>
                    <div class="question">
                        <p><strong>Olanaklar</strong></p>
                        <div class="btn-group btn-group-toggle white" data-toggle="buttons">
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="olanaklar" id="option1">
                                <svg class="bk-icon -iconset-review_poor" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 30.2a4 4 0 1 1-5.6 5.6c-10.5-10.4-24-10.4-34.4 0a4 4 0 0 1-5.6-5.6c13.6-13.7 32-13.7 45.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="olanaklar" id="option2">
                                <svg class="bk-icon -iconset-review_average" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4 28a4 4 0 0 1-4 4H44a4 4 0 0 1 0-8h40a4 4 0 0 1 4 4z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="olanaklar" id="option3">
                                <svg class="bk-icon -iconset-review_good" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 21.2a4 4 0 0 1 0 5.6A32 32 0 0 1 64 93.1c-8 0-16-3.4-22.8-10.3a4 4 0 0 1 5.6-5.6c10.5 10.4 24 10.4 34.4 0a4 4 0 0 1 5.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="olanaklar" id="option4">
                                <svg class="bk-icon -iconset-review_great" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4.8 21.6a4 4 0 0 1 .6 3.6A24.3 24.3 0 0 1 64 97c-9.7 0-15.7-4.2-19-7.8a22.7 22.7 0 0 1-4.8-8A4 4 0 0 1 44 76h40a4 4 0 0 1 3.2 1.6z"></path></svg>
                            </label>
                        </div>
                    </div>
                    <div class="question">
                        <p><strong>Temizlik</strong></p>
                        <div class="btn-group btn-group-toggle white" data-toggle="buttons">
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="temizlik" id="option1">
                                <svg class="bk-icon -iconset-review_poor" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 30.2a4 4 0 1 1-5.6 5.6c-10.5-10.4-24-10.4-34.4 0a4 4 0 0 1-5.6-5.6c13.6-13.7 32-13.7 45.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="temizlik" id="option2">
                                <svg class="bk-icon -iconset-review_average" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4 28a4 4 0 0 1-4 4H44a4 4 0 0 1 0-8h40a4 4 0 0 1 4 4z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="temizlik" id="option3">
                                <svg class="bk-icon -iconset-review_good" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 21.2a4 4 0 0 1 0 5.6A32 32 0 0 1 64 93.1c-8 0-16-3.4-22.8-10.3a4 4 0 0 1 5.6-5.6c10.5 10.4 24 10.4 34.4 0a4 4 0 0 1 5.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="temizlik" id="option4">
                                <svg class="bk-icon -iconset-review_great" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4.8 21.6a4 4 0 0 1 .6 3.6A24.3 24.3 0 0 1 64 97c-9.7 0-15.7-4.2-19-7.8a22.7 22.7 0 0 1-4.8-8A4 4 0 0 1 44 76h40a4 4 0 0 1 3.2 1.6z"></path></svg>
                            </label>
                        </div>
                    </div>
                    <div class="question">
                        <p><strong>Rahatlık</strong></p>
                        <div class="btn-group btn-group-toggle white" data-toggle="buttons">
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="rahatlik" id="option1">
                                <svg class="bk-icon -iconset-review_poor" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 30.2a4 4 0 1 1-5.6 5.6c-10.5-10.4-24-10.4-34.4 0a4 4 0 0 1-5.6-5.6c13.6-13.7 32-13.7 45.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="rahatlik" id="option2">
                                <svg class="bk-icon -iconset-review_average" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4 28a4 4 0 0 1-4 4H44a4 4 0 0 1 0-8h40a4 4 0 0 1 4 4z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="rahatlik" id="option3">
                                <svg class="bk-icon -iconset-review_good" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 21.2a4 4 0 0 1 0 5.6A32 32 0 0 1 64 93.1c-8 0-16-3.4-22.8-10.3a4 4 0 0 1 5.6-5.6c10.5 10.4 24 10.4 34.4 0a4 4 0 0 1 5.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="rahatlik" id="option4">
                                <svg class="bk-icon -iconset-review_great" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4.8 21.6a4 4 0 0 1 .6 3.6A24.3 24.3 0 0 1 64 97c-9.7 0-15.7-4.2-19-7.8a22.7 22.7 0 0 1-4.8-8A4 4 0 0 1 44 76h40a4 4 0 0 1 3.2 1.6z"></path></svg>
                            </label>
                        </div>
                    </div>
                    <div class="question">
                        <p><strong>Fiyat/Fayda Dengesi</strong></p>
                        <div class="btn-group btn-group-toggle white" data-toggle="buttons">
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="fiyatfayda" id="option1">
                                <svg class="bk-icon -iconset-review_poor" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 30.2a4 4 0 1 1-5.6 5.6c-10.5-10.4-24-10.4-34.4 0a4 4 0 0 1-5.6-5.6c13.6-13.7 32-13.7 45.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="fiyatfayda" id="option2">
                                <svg class="bk-icon -iconset-review_average" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4 28a4 4 0 0 1-4 4H44a4 4 0 0 1 0-8h40a4 4 0 0 1 4 4z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="fiyatfayda" id="option3">
                                <svg class="bk-icon -iconset-review_good" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 21.2a4 4 0 0 1 0 5.6A32 32 0 0 1 64 93.1c-8 0-16-3.4-22.8-10.3a4 4 0 0 1 5.6-5.6c10.5 10.4 24 10.4 34.4 0a4 4 0 0 1 5.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="fiyatfayda" id="option4">
                                <svg class="bk-icon -iconset-review_great" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4.8 21.6a4 4 0 0 1 .6 3.6A24.3 24.3 0 0 1 64 97c-9.7 0-15.7-4.2-19-7.8a22.7 22.7 0 0 1-4.8-8A4 4 0 0 1 44 76h40a4 4 0 0 1 3.2 1.6z"></path></svg>
                            </label>
                        </div>
                    </div>
                    <div class="question">
                        <p><strong>Konum</strong></p>
                        <div class="btn-group btn-group-toggle white" data-toggle="buttons">
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="konum" id="option1">
                                <svg class="bk-icon -iconset-review_poor" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 30.2a4 4 0 1 1-5.6 5.6c-10.5-10.4-24-10.4-34.4 0a4 4 0 0 1-5.6-5.6c13.6-13.7 32-13.7 45.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="konum" id="option2">
                                <svg class="bk-icon -iconset-review_average" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4 28a4 4 0 0 1-4 4H44a4 4 0 0 1 0-8h40a4 4 0 0 1 4 4z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="konum" id="option3">
                                <svg class="bk-icon -iconset-review_good" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 21.2a4 4 0 0 1 0 5.6A32 32 0 0 1 64 93.1c-8 0-16-3.4-22.8-10.3a4 4 0 0 1 5.6-5.6c10.5 10.4 24 10.4 34.4 0a4 4 0 0 1 5.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="konum" id="option4">
                                <svg class="bk-icon -iconset-review_great" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4.8 21.6a4 4 0 0 1 .6 3.6A24.3 24.3 0 0 1 64 97c-9.7 0-15.7-4.2-19-7.8a22.7 22.7 0 0 1-4.8-8A4 4 0 0 1 44 76h40a4 4 0 0 1 3.2 1.6z"></path></svg>
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <div class="custom-card mt-5">
                <form class="custom-form">
                    <div class="question">
                        <h4 class="question-title">3. Biraz daha fazla bilgi verebilir misiniz?</h4>
                        <p><strong>Varışta tesis anahtarlarını almak ne kadar kolaydı?</strong></p>
                        <div class="btn-group btn-group-toggle white" data-toggle="buttons">
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="anahtar" id="option1">
                                <svg class="bk-icon -iconset-review_poor" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 30.2a4 4 0 1 1-5.6 5.6c-10.5-10.4-24-10.4-34.4 0a4 4 0 0 1-5.6-5.6c13.6-13.7 32-13.7 45.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="anahtar" id="option2">
                                <svg class="bk-icon -iconset-review_average" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4 28a4 4 0 0 1-4 4H44a4 4 0 0 1 0-8h40a4 4 0 0 1 4 4z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="anahtar" id="option3">
                                <svg class="bk-icon -iconset-review_good" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-5.2 21.2a4 4 0 0 1 0 5.6A32 32 0 0 1 64 93.1c-8 0-16-3.4-22.8-10.3a4 4 0 0 1 5.6-5.6c10.5 10.4 24 10.4 34.4 0a4 4 0 0 1 5.6 0z"></path></svg>
                            </label>
                            <label data-toggle="tooltip" title="Hayal kırıklığı" class="btn btn-secondary">
                                <input type="radio" name="anahtar" id="option4">
                                <svg class="bk-icon -iconset-review_great" fill="#6B6B6B" height="32" width="32" viewBox="0 0 128 128" role="presentation" aria-hidden="true" focusable="false"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 1 1 48-48 48 48 0 0 1-48 48zM44 64a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm48-8a8 8 0 1 1-8-8 8 8 0 0 1 8 8zm-4.8 21.6a4 4 0 0 1 .6 3.6A24.3 24.3 0 0 1 64 97c-9.7 0-15.7-4.2-19-7.8a22.7 22.7 0 0 1-4.8-8A4 4 0 0 1 44 76h40a4 4 0 0 1 3.2 1.6z"></path></svg>
                            </label>
                        </div>
                        <div class="form-item">
                            <input type="checkbox" id="gecerli" name="tesisanahtar">
                            <label for="gecerli">Geçerli değil</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <p><strong>Neyi sevdiniz?</strong></p>
                        <textarea rows="6" placeholder="Kahvaltı hakkında ne düşünüyorsunuz? Konum nasıldı?"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <p><strong>Neyi sevmediniz?</strong></p>
                        <textarea rows="6" placeholder="Kahvaltı neler daha iyi olabilirdi?"></textarea>
                    </div>

                    <div class="form-group">
                        <p><strong>Konaklamanızı özetlemek için kısa bir cümle yazın.</strong></p>
                        <input type="text">
                    </div>

                </form>
            </div>

            <div class="custom-card mt-5">
                <form class="custom-form">
                    <div class="question">
                        <h4 class="question-title">4. En yakındaki plajlardan biri La Porta Beach idi. Burayı ziyaret ettiniz mi?</h4>
                    </div>
                    <div class="form-group">
                        <div class="form-item">
                            <input type="radio" id="evet" name="tavsiye">
                            <label for="evet">Evet</label>
                        </div>
                        <div class="form-item">
                            <input type="radio" id="hayır" name="tavsiye">
                            <label for="hayır">Hayır</label>
                        </div>
                    </div>
                </form>
            </div>

            <div class="custom-card mt-5">
                <form class="custom-form mb-0">
                    <div class="question">
                        <h4 class="question-title">5. Fotoğraf yükleyin</h4>
                        <small>Diğer gezginlerin manzaraları sizin gözünüzden görmelerini sağlayın. Fotoğraflarınız başka insanların seyahatleri konusunda karar vermelerine yardımcı oluyor.</small>
                    </div>
                    <input type="file" name="surveyfiles">
                </form>
            </div>

            <button type="submit" class="btn btn-warning w-100 btn-lg d-flex justify-content-center align-items-center">Tamamla <i style="margin-left: 10px;"class="icon icon-header-arrow-right"></i></button>
            
        </div>
    </div>
</div>