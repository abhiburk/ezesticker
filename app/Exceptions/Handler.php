<?php
 
namespace App\Exceptions;
 
use App\Mail\ExceptionOccured;
use Exception;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];
 
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
 
    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {   
       if ($this->shouldReport($exception) && env('APP_ENV') == 'production') {
            $this->sendEmail($exception); // sends an email
        }
        parent::report($exception);
    }
 
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }
 
    public function sendEmail(Exception $exception)
    {
        $e = FlattenException::create($exception);
        $handler = new HtmlErrorRenderer(true); // boolean, true raises debug flag...
        $css = $handler->getStylesheet();
        $content = $handler->getBody($e);
        Mail::to(ADMIN_EMAILS)->queue(new ExceptionOccured($css, $content));
    }
}